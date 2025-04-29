@extends('admin.layouts.template')

@section('title', 'Editar Pedido')

@section('content_header')
<div class="container">
    <h1>Detalles Pedido</h1>
</div>
@endsection

@section('content')
<div class="container space-y-6">
    
    <div class="container">
        <h2>Detalles de la Orden</h2>
        <div class="relative overflow-x-auto overflow-hidden rounded-lg shadow-md">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-collapse">
                <thead class="text-xs text-gray-900 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID Orden</th>
                        <th scope="col" class="px-6 py-3">Fecha</th>
                        <th scope="col" class="px-6 py-3">Dirección</th>
                        <th scope="col" class="px-6 py-3">Total a pagar</th>
                        <th scope="col" class="px-6 py-3">Estado</th>
                        <th scope="col" class="px-6 py-3">Stripe ID</th> <!-- REFERENCIA STRIPE -->
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $orden->ID_Orden }}</td>
                        <td class="px-6 py-4">{{ $orden->fecha }}</td>
                        <td class="px-6 py-4">{{ $orden->direccion->calle_principal }}, {{ $orden->direccion->ciudad }}</td>
                        <td class="px-6 py-4">${{ $orden->total }}</td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('pedidos.update', $orden->ID_Orden) }}" method="POST" class="flex flex-col">
                                @csrf
                                @method('PATCH')

                                <!-- Si el estado es 'entregado' o 'cancelado', deshabilitar la selección -->
                                <select name="estado" class="form-control text-center w-40 px-3 py-2 border rounded-lg"
                                    @if($orden->estado == 'entregado' || $orden->estado == 'cancelado') disabled @endif>
                                    
                                    <!-- Estado pedido solo disponible si el estado actual es 'pedido' -->
                                    @if($orden->estado == 'pedido')
                                        <option value="pedido" {{ $orden->estado == 'pedido' ? 'selected' : '' }}>Pedido</option>
                                        <option value="enviado">Enviado</option>
                                        <option value="cancelado">Cancelado</option>
                                    @elseif($orden->estado == 'enviado')
                                        <!-- Estado enviado no permite volver a 'pedido', pero sí a 'entregado' o 'cancelado' -->
                                        <option value="enviado" {{ $orden->estado == 'enviado' ? 'selected' : '' }}>Enviado</option>
                                        <option value="entregado">Entregado</option>
                                        <option value="cancelado">Cancelado</option>
                                    @else
                                        <!-- Si ya está en 'entregado' o 'cancelado', no se puede cambiar -->
                                        <option value="{{ $orden->estado }}" selected>{{ ucfirst($orden->estado) }}</option>
                                    @endif
                                </select>

                                <!-- Ocultar el botón "Actualizar" si el estado es 'entregado' o 'cancelado' -->
                                @if($orden->estado != 'entregado' && $orden->estado != 'cancelado')
                                    <button type="submit" class="btn btn-primary mt-2 w-40 text-center px-3 py-2 border rounded-lg">Actualizar</button>
                                @endif
                            </form>
                        </td>
                        <td class="px-6 py-4">{{ $orden->stripe_id ?? 'No disponible' }}</td> <!-- REFERENCIA DONDE ESTÁ STRIPE -->                       
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container">
        <h3>Artículos</h3>
        <div class="relative overflow-x-auto overflow-hidden rounded-lg shadow-md">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-collapse">
                <thead class="text-xs text-gray-900 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3">Imagen</th>
                        <th scope="col" class="px-6 py-3">Nombre</th>
                        <th scope="col" class="px-6 py-3">ID Producto</th>
                        <th scope="col" class="px-6 py-3">Modelo</th>
                        <th scope="col" class="px-6 py-3">Cantidad</th>
                        <th scope="col" class="px-6 py-3">Precio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orden->productos as $productoOrden)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">
    @if($productoOrden->url_photo)
        <img src="{{ asset('storage/' . json_decode($productoOrden->url_photo, true)[0] ) }}" alt="Producto" class="rounded-lg max-w-[80px] max-h-[80px]">
    @else
        <span>No disponible</span>
    @endif
</td>                        <td class="px-6 py-4">{{ $productoOrden->nombre }}</td>
                        <td class="px-6 py-4">{{ $productoOrden->pivot->ID_Producto }}</td>
                        <td class="px-6 py-4">{{ $productoOrden->modelo }}</td>
                        <td class="px-6 py-4">{{ $productoOrden->pivot->cantidad }}</td>
                        <td class="px-6 py-4">${{ $productoOrden->pivot->precio }}</td>
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
                        <th scope="col" class="px-6 py-3">ID Usuario</th>
                        <th scope="col" class="px-6 py-3">Nombre</th>
                        <th scope="col" class="px-6 py-3">Dirección</th>
                        <th scope="col" class="px-6 py-3">Teléfono</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $orden->ID_Usuario }}</td>
                        <td class="px-6 py-4">{{ $orden->usuario->name ?? 'No disponible'}}</td>
                        <td class="px-6 py-4">{{ $orden->direccion->calle_principal }}, {{ $orden->direccion->ciudad }}</td>
                        <td class="px-6 py-4">{{ $orden->usuario->cellphone ?? 'No disponible' }}</td>
                        <td class="px-6 py-4">{{ $orden->usuario->email ?? 'No disponible'}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container">
        <a href="{{ route('pedidos.index')}}"" class="inline-flex items-center w-min px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Regresar
        </a>
    </div>
    
</div>
@endsection
