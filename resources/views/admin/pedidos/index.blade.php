@extends('admin.layouts.template')

@section('title', 'Pedidos')

@section('content_header')
<div class="container space-y-4">
    <h1 class="text-3xl font-semibold">Pedidos</h1>

    @if (Session::get('success'))
        <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-200 dark:bg-gray-800 dark:text-green-400" role="alert">
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
                <strong>{{Session::get('success')}}</strong>
            </div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-70 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    <div class="row justify-between mx-0">
        <!-- Barra de búsqueda y filtros -->
        <form method="GET" action="{{ route('pedidos.index') }}" class="flex flex-wrap items-center gap-2">
            <!-- Filtro por fecha -->
            <select name="fecha" id="fecha" class="form-select min-w-40 text-center px-3 py-2 border rounded-lg">
                <option value="">Fecha</option>
                <option value="asc" {{ request('fecha') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                <option value="desc" {{ request('fecha') == 'desc' ? 'selected' : '' }}>Descendente</option>
            </select>

            <!-- Filtro por total -->
            <select name="total" id="total" class="form-select min-w-40 text-center px-3 py-2 border rounded-lg">
                <option value="">Precio</option>
                <option value="asc" {{ request('total') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                <option value="desc" {{ request('total') == 'desc' ? 'selected' : '' }}>Descendente</option>
            </select>

            <!-- Filtro por estado -->
            <select name="estado" id="estado" class="form-select min-w-40 text-center px-3 py-2 border rounded-lg">
                <option value="">Estado</option>
                <option value="pedido" {{ request('estado') == 'pedido' ? 'selected' : '' }}>Pedido</option>
                <option value="enviado" {{ request('estado') == 'enviado' ? 'selected' : '' }}>Enviado</option>
                <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>

            <!-- Botones de buscar y resetear -->
            <button type="submit" class="btn btn-primary min-w-20 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-3 rounded-lg">Buscar</button>
            <a href="{{ route('pedidos.index') }}" class="btn btn-secondary min-w-20 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-3 rounded-lg">Reset Filter</a>
        </form>

        <form method="GET" action="{{ route('pedidos.index') }}" class="flex items-center gap-2">
            <input type="text" name="search" id="search" class="form-control min-w-80 text-start py-2 px-3 border rounded-lg" placeholder="Buscar por ID Pedido...">
            <button type="submit" class="btn btn-primary min-w-20 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-3 rounded-lg">Buscar</button>
        </form>
    </div>

    <div class="relative overflow-x-auto overflow-hidden rounded-lg shadow-md">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-900 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Usuario</th>
                    <th scope="col" class="px-6 py-3">Direccion</th>
                    <th scope="col" class="px-6 py-3">Fecha</th>
                    <th scope="col" class="px-6 py-3">Precio</th>
                    <th scope="col" class="px-6 py-3">Estado</th>
                    <th scope="col" class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ordenes as $orden)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $orden->ID_Orden }}</td>
                    <td class="px-6 py-4">{{ $orden->usuario->name }}</td>
                    <td class="px-6 py-4">
                        <p>Ciudad: {{ $orden->direccion->ciudad }}</p> 
                        <p>CP: {{ $orden->direccion->codigo_postal }}</p>
                        <p>Calle: {{ $orden->direccion->calle_principal }}</p> 
                        <p>Cruzamientos: {{ $orden->direccion->cruzamientos }}</p>
                        <p>No. Ext. {{ $orden->direccion->numero_exterior }}</p> 
                        <p>No. Int.: {{ $orden->direccion->numero_interior }}</p>
                        <p>Detalles: {{ $orden->direccion->detalles }}</p>
                    </td>
                    <td class="px-6 py-4">{{ $orden->fecha }}</td>
                    <td class="px-6 py-4"><span>$ </span>{{ $orden->total }}</td>
                    <td class="px-6 py-4">
                        <span class="px-4 py-2 font-bold leading-tight rounded-lg
                            {{ $orden->estado == 'pedido' ? 'bg-blue-200 text-blue-800' : '' }}
                            {{ $orden->estado == 'enviado' ? 'bg-yellow-200 text-yellow-800' : '' }}
                            {{ $orden->estado == 'entregado' ? 'bg-green-200 text-green-800' : '' }}
                            {{ $orden->estado == 'cancelado' ? 'bg-red-200 text-red-800' : '' }}">
                            {{ ucfirst($orden->estado) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('pedidos.edit', $orden->ID_Orden) }}" class="font-bold text-blue-600 dark:text-blue-500 hover:underline">Más Detalles</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center px-6 py-4">No hay órdenes disponibles.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection