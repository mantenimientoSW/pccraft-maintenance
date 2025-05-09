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
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function productos()
    {
        try {
            return $this->belongsToMany(Product::class, 'producto__ordens')
                    ->withPivot('cantidad', 'precio');
        } catch (Exception $e) {
            throw new Exception('Error al obtener los productos de la orden: ' . $e->getMessage());
        }
    }

    public function index(Request $request)
    {
        try {
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
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar los pedidos: ' . $e->getMessage());
        }
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
        try {
            // Mostrar detalles de la orden y los productos relacionados
            $orden = Orden::with('productos')->findOrFail($id);

            return view('admin.pedidos.show', compact('orden'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('pedidos.index')
                ->with('error', 'El pedido no fue encontrado.');
        } catch (Exception $e) {
            return redirect()->route('pedidos.index')
                ->with('error', 'Error al cargar los detalles del pedido: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            // Mostrar formulario para editar la orden
            $orden = Orden::findOrFail($id);

            return view('admin.pedidos.edit', compact('orden'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('pedidos.index')
                ->with('error', 'El pedido no fue encontrado.');
        } catch (Exception $e) {
            return redirect()->route('pedidos.index')
                ->with('error', 'Error al cargar el pedido: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'estado' => 'required|in:pedido,enviado,entregado,cancelado',
            ]);

            $orden = Orden::findOrFail($id);
            
            if (in_array($orden->estado, ['entregado', 'cancelado'])) {
                throw new Exception('No puedes cambiar un pedido que ya ha sido entregado o cancelado.');
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
            
            try {
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
            } catch (Exception $e) {
                // Log el error de envío de correo pero no interrumpir la transacción
                \Log::error('Error al enviar correo: ' . $e->getMessage());
            }

            DB::commit();
            return redirect()->route('pedidos.index')->with('success', '¡Estado del Pedido Actualizado Exitosamente!');

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('pedidos.index')
                ->with('error', 'El pedido no fue encontrado.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el pedido en la base de datos: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el pedido: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $orden = Orden::findOrFail($id);
            $orden->delete();

            DB::commit();
            return redirect()->route('pedidos.index')->with('success', '¡Orden eliminada correctamente!');

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('pedidos.index')
                ->with('error', 'El pedido no fue encontrado.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('pedidos.index')
                ->with('error', 'No se puede eliminar el pedido porque está siendo utilizado.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('pedidos.index')
                ->with('error', 'Error al eliminar el pedido: ' . $e->getMessage());
        }
    }
}
