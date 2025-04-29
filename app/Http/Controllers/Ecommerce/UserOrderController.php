<?php
namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Orden;
use App\Models\Producto;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon; 
use App\Mail\OrderCancelledMail; 
use Illuminate\Support\Facades\Mail;


class UserOrderController extends Controller
{
    // Mostrar las órdenes del usuario autenticado
    public function index(Request $request)
{
    $query = Orden::where('ID_Usuario', auth()->id());

    // Validar y aplicar el ordenamiento para fecha
    if ($request->filled('fecha') && in_array($request->fecha, ['asc', 'desc'])) {
        $query->orderBy('agregada', $request->fecha);
    }

    // Validar y aplicar el ordenamiento para total
    if ($request->filled('total') && in_array($request->total, ['asc', 'desc'])) {
        $query->orderBy('total', $request->total);
    }

    // Filtro por estado de la orden
    if ($request->filled('estado')) {
        $query->where('estado', $request->estado);
    }

    // Filtro de búsqueda por ID de pedido
    if ($request->filled('search')) {
        $query->where('ID_Orden', 'like', '%' . $request->search . '%');
    }

    // Paginar las órdenes del usuario autenticado
    $orders = $query->paginate(10);

    // Retornar la vista con las órdenes filtradas
    return view('ecommerce.user.ordersUser', compact('orders'));
}

    // Muestra los detalles de una orden específica
    public function show($id)
    {
        $order = Orden::where('ID_Usuario', auth()->id())->findOrFail($id);

        // Retorna la vista de detalle de la orden
        return view('ecommerce.user.show', compact('order'));
    }
    
    public function reviewForm(Request $request, $orderId, $productId)
    {
        // Obtener la orden del usuario autenticado
        $order = Orden::where('ID_Usuario', auth()->id())->findOrFail($orderId);

        // Obtener el producto de la orden
        $producto = $order->productos->find($productId);

        // Si es una solicitud GET, mostramos el formulario
        if ($request->isMethod('get')) {
            // Verificar si ya existe una reseña
            $review = Review::where('ID_Review', $producto->pivot->ID_Review)->first();
            return view('ecommerce.comment', compact('order', 'producto', 'review'));
        }

        // Si es una solicitud POST, validamos y guardamos la reseña
        if ($request->isMethod('post')) {
            // Validar los datos del formulario
            $validated = $request->validate([
                'title' => 'nullable|string|max:255',
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'required|string|max:1000',
            ]);

            // Crear una nueva reseña o actualizar la existente
            $review = $producto->pivot->ID_Review ? Review::find($producto->pivot->ID_Review) : new Review();
            $review->titulo = $validated['title'];
            $review->comentario = $validated['review'];
            $review->calificacion = $validated['rating'];
            $review->fecha = now();
            $review->save();

            // Asociar la reseña al producto en la tabla pivote si es una nueva reseña
            if (is_null($producto->pivot->ID_Review)) {
                $producto->pivot->ID_Review = $review->ID_Review;
                $producto->pivot->save();
            }

            return redirect()->route('user.orders.show', $orderId)->with('success', 'Reseña publicada con éxito.');
        }
    }
    
    // Método para actualizar el estado de una orden
    public function update(Request $request, $id)
    {
        $order = Orden::where('ID_Usuario', auth()->id())->findOrFail($id);

        // Solo permitir actualización si el estado es 'pedido' o 'enviado'
        if ($order->estado == 'pedido' || $order->estado == 'enviado') {
            $validatedData = $request->validate([
                'estado' => 'required|in:pedido,enviado,cancelado',
            ]);
            
            if ($validatedData['estado'] == 'cancelado') {
                $order->fecha_cancelado = Carbon::now();
                Mail::to($order->usuario->email)->send(new OrderCancelledMail($order));
                foreach ($order->productos as $producto) {
                    $cantidadPedida = $producto->pivot->cantidad; // Cantidad en la orden
                    $producto->stock += $cantidadPedida; // Incrementa el stock
                    $producto->save(); // Guarda el cambio en la base de datos
                }
            }

            $order->estado = $validatedData['estado'];
            $order->save();

            return redirect()->route('user.orders.show', $order->ID_Orden)
                             ->with('success', 'El estado de la orden ha sido actualizado.');
        }

        return redirect()->route('user.orders.show', $order->ID_Orden)
                         ->with('error', 'No se puede cambiar el estado de esta orden.');
    }
}
