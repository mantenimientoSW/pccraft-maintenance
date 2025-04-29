<?php

namespace App\Http\Controllers\Admin;

use App\Models\Orden;
use App\Models\Product;
use App\Models\User;
use App\Models\Producto_Orden;
use App\Models\Direccion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\OrderShippedMail;
use App\Mail\OrderDeliveredMail;
use App\Mail\OrderCancelledMail;
use Illuminate\Support\Facades\Mail;
use App\Events\OrderStatusChanged;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function productos()
{
    return $this->belongsToMany(Product::class, 'producto__ordens')
                ->withPivot('cantidad', 'precio');
}

    public function index(Request $request)
    {
        $query = Orden::query();

        // Filtro por fecha
        if ($request->filled('fecha')) {
            $query->orderBy('fecha', $request->fecha);
        }

        // Filtro por total
        if ($request->filled('total')) {
            $query->orderBy('total', $request->total);
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Buscar por ID de orden
        if ($request->filled('search')) {
            $query->where('ID_Orden', $request->search);
        }

        $ordenes = $query->get();

        return view('admin.pedidos.index', compact('ordenes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Lógica para crear un nuevo pedido si es necesario
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Aquí se puede implementar la lógica de creación de una nueva orden
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Mostrar detalles de la orden y los productos relacionados
        $orden = Orden::with('productos')->findOrFail($id);

        return view('admin.pedidos.show', compact('orden'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Mostrar formulario para editar la orden
        $orden = Orden::findOrFail($id);

        return view('admin.pedidos.edit', compact('orden'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar el estado que será actualizado
        $request->validate([
            'estado' => 'required|in:pedido,enviado,entregado,cancelado',
        ]);

        // Actualizar el estado de la orden
        $orden = Orden::findOrFail($id);
        //evitar que toquen el front y engañar
        if (in_array($orden->estado, ['entregado', 'cancelado'])) {
            return redirect()->route('pedidos.index')->with('error', 'No puedes cambiar un pedido que ya ha sido entregado o cancelado.');
        }

        $orden->estado = $request->estado;
        // se pudo unir el switch, si. pero primero guardar los datos en la bd para luego mandar correos no?
        switch ($request->estado) {
            case 'enviado':
                $orden->fecha_enviado = now();
                break;
            case 'entregado':
                $orden->fecha_entregado = now();
                break;
            case 'cancelado':
                $orden->fecha_cancelado = now();
                foreach ($orden->productos as $producto) {
                    $cantidadPedida = $producto->pivot->cantidad; // Cantidad en la orden
                    $producto->stock += $cantidadPedida; // Incrementa el stock
                    $producto->save(); // Guarda el cambio en la base de datos
                }
                break;
        }
        $orden->save();
        
        // Disparar Evento para actualizar los productos recomendados != 'cancelado'
        event(new OrderStatusChanged($orden));
        
        switch ($orden->estado) {
            case 'enviado':
                Mail::to($orden->usuario->email)->send(new OrderShippedMail($orden));
                break;
            case 'entregado':
                Mail::to($orden->usuario->email)->send(new OrderDeliveredMail($orden));
                break;
            case 'cancelado':
                Mail::to($orden->usuario->email)->send(new OrderCancelledMail($orden));
                break;
        }
        return redirect()->route('pedidos.index')->with('success', '¡Estado del Pedido Actualizado Exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Eliminar la orden de forma segura
        $orden = Orden::findOrFail($id);
        $orden->delete();

        return redirect()->route('pedidos.index')->with('success', '¡Orden eliminada correctamente!');
    }
}
