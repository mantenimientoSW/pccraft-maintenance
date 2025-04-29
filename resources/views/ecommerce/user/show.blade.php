@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Detalles de la Orden #{{ $order->ID_Orden }}</h1>

    <div class="bg-white shadow sm:rounded-lg p-6">
        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Información de la Orden</h3>
        
        <!-- Order details structured in a table format -->
        <div class="relative overflow-x-auto rounded-lg shadow-md">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
                <thead class="bg-gray-200 text-xs text-gray-900 uppercase dark:bg-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-6 py-3">ID Orden</th>
                        <th class="px-6 py-3">Fecha</th>
                        <th class="px-6 py-3">Estado</th>
                        <th class="px-6 py-3">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $order->ID_Orden }}</td>
                        <td class="px-6 py-4">
                            @if ($order->estado == 'pedido')
                                {{ \Carbon\Carbon::parse($order->agregada)->format('d/m/Y') }}
                            @elseif ($order->estado == 'enviado')
                                {{ $order->fecha_enviado ? \Carbon\Carbon::parse($order->fecha_enviado)->format('d/m/Y') : 'Sin fecha' }}
                            @elseif ($order->estado == 'cancelado')
                                {{ $order->fecha_cancelado ? \Carbon\Carbon::parse($order->fecha_cancelado)->format('d/m/Y') : 'Sin fecha' }}
                            @elseif ($order->estado == 'entregado')
                                {{ $order->fecha_entregado ? \Carbon\Carbon::parse($order->fecha_entregado)->format('d/m/Y') : 'Sin fecha' }}
                            @else
                                {{ 'Sin estado definido' }}
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <!-- Mostrar el formulario si el estado es pendiente o enviado -->
                            @if($order->estado == 'pedido' || $order->estado == 'enviado')
                                <!-- Formulario para cambiar el estado -->
                                <form action="{{ route('user.orders.update', $order->ID_Orden) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="estado" id="estado" class="form-select text-center px-3 py-2 border rounded-lg">
                                        <!-- Mostrar el estado actual y permitir cambiar a cancelado -->
                                        <option value="{{ $order->estado }}" selected>{{ ucfirst($order->estado) }}</option>
                                        <option value="cancelado">Cancelado</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg ml-4">Actualizar</button>
                                </form>
                            @else
                                <!-- Estado no editable si es 'cancelado' o 'entregado' -->
                                <span class="px-4 py-2 font-bold leading-tight rounded-lg 
                                    {{ $order->estado == 'cancelado' ? 'bg-red-200 text-red-800' : 'bg-green-200 text-green-800' }}">
                                    {{ ucfirst($order->estado) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ number_format($order->total, 2) }} MXN</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4 mt-6">Productos en la Orden</h3>
        
        <!-- Tabla de detalles del producto -->
        <div class="relative overflow-x-auto rounded-lg shadow-md">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
                <thead class="bg-gray-200 text-xs text-gray-900 uppercase dark:bg-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-6 py-3">Imagen</th>
                        <th class="px-6 py-3">Producto</th>
                        <th class="px-6 py-3">Cantidad</th>
                        <th class="px-6 py-3">Precio Unitario</th>
                        <th class="px-6 py-3">Subtotal</th>
                        <th class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($order->productos as $producto)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">
                            @if($producto->url_photo)
                                <img src="{{ asset('storage/' . json_decode($producto->url_photo, true)[0] ) }}" alt="Producto" class="rounded-lg max-w-[80px] max-h-[80px]">
                            @else
                                <span>No disponible</span>
                            @endif
                        </td>   
                        <td class="px-6 py-4">
                            <a href="/productos/{{ $producto->pivot->ID_Producto }}" class="text-blue-500 hover:underline">
                                {{ $producto->nombre }}
                            </a>
                        </td>
                        <td class="px-6 py-4">{{ $producto->pivot->cantidad }}</td>
                        <td class="px-6 py-4">{{ number_format($producto->pivot->precio, 2) }} MXN</td>
                        <td class="px-6 py-4">{{ number_format($producto->pivot->cantidad * $producto->pivot->precio, 2) }} MXN</td>

                        <!-- Columna de Acciones -->
                        <td class="px-6 py-4">
                        @if ($order->estado == 'entregado')
                            <!-- Si no tiene reseña (ID_Review está vacío) -->
                            @if (is_null($producto->pivot->ID_Review))
                                <a href="{{ route('comment.index', ['orderId' => $order->ID_Orden, 'productId' => $producto->pivot->ID_Producto]) }}" class="text-blue-500 hover:underline">Reseñar</a>
                            @else
                                <!-- Verificar si la reseña tiene menos de un día -->
                                @php
                                    $review = \App\Models\Review::find($producto->pivot->ID_Review);
                                    $canEdit = $review && \Carbon\Carbon::parse($review->created_at)->diffInDays(now()) < 1;
                                @endphp

                                @if ($canEdit)
                                    <a href="{{ route('comment.index', ['orderId' => $order->ID_Orden, 'productId' => $producto->pivot->ID_Producto]) }}" class="text-blue-500 hover:underline">Editar Reseña</a>
                                @else
                                    <span class="text-gray-500">Reseña enviada</span>
                                @endif
                            @endif
                        @else
                            <span class="text-gray-500">Acción no disponible</span>
                        @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <div class="container">
        <h3>Datos del Usuario</h3>
        <div class="relative overflow-x-auto overflow-hidden rounded-lg shadow-md">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-collapse">
                <thead class="text-xs text-gray-900 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nombre</th>
                        <th scope="col" class="px-6 py-3">Dirección</th>
                        <th scope="col" class="px-6 py-3">Teléfono</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $order->usuario->name ?? 'No disponible'}}</td>
                        <td class="px-6 py-4">{{ $order->direccion->calle_principal }}, {{ $order->direccion->ciudad }}</td>
                        <td class="px-6 py-4">{{ $order->usuario->cellphone ?? 'No disponible' }}</td>
                        <td class="px-6 py-4">{{ $order->usuario->email ?? 'No disponible'}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container mt-6 text-right">
        <a href="{{ route('user.orders.index')}}"" class="inline-flex items-center w-min px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Regresar
        </a>
    </div>
</div>
@endsection
