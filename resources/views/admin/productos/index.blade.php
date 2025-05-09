@extends('admin.layouts.template')

@section('title', 'Productos')

@section('content_header')
<div class="container space-y-4">
    <h1 class="text-3xl font-semibold">Productos</h1>

    <div class="row justify-between mx-0">
        <!-- Barra de búsqueda y filtros -->
        <form method="GET" action="{{ route('productos.index') }}" class="flex flex-wrap items-center gap-2">
            <!-- Filtro por fecha -->
            <select name="fecha" id="fecha" class="form-select min-w-40 text-center px-3 py-2 border rounded-lg">
                <option value="">Fecha</option>
                <option value="asc" {{ request('fecha') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                <option value="desc" {{ request('fecha') == 'desc' ? 'selected' : '' }}>Descendente</option>
            </select>

            <!-- Filtro por precio -->
            <select name="precio" id="precio" class="form-select min-w-40 text-center px-3 py-2 border rounded-lg">
                <option value="">Precio</option>
                <option value="asc" {{ request('precio') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                <option value="desc" {{ request('precio') == 'desc' ? 'selected' : '' }}>Descendente</option>
            </select>

            <!-- Filtro por categoría -->
            <select name="categoria" id="categoria" class="form-select min-w-40 text-center px-3 py-2 border rounded-lg">
                <option value="">Categoría</option>
                @foreach($categories as $category)
                    <option value="{{ $category->ID_Categoria }}" {{ request('categoria') == $category->ID_Categoria ? 'selected' : '' }}>
                        {{ $category->nombre_categoria }}
                    </option>
                @endforeach
            </select>

            <!-- Botones de buscar y resetear -->
            <button type="submit" class="btn btn-primary min-w-20 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-3 rounded-lg">Buscar</button>
            <a href="{{ route('productos.index') }}" class="btn btn-secondary min-w-20 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-3 rounded-lg">Reset Filter</a>
        </form>

        <form method="GET" action="{{ route('productos.index') }}" class="flex items-center gap-2">
            <input type="text" name="search" class="form-control min-w-80 text-start py-2 px-3 border rounded-lg" placeholder="Buscar Venta...">
            <button type="submit" class="btn btn-primary min-w-20 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-3 rounded-lg">Buscar</button>
        </form>

        <a href="{{ route('productos.create') }}" class="btn btn-primary bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">+ Agregar Nuevo Producto</a>
    </div>

    <div class="relative overflow-x-auto overflow-hidden rounded-lg shadow-md">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-900 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Nombre</th>
                    <th scope="col" class="px-6 py-3">Modelo</th>
                    <th scope="col" class="px-6 py-3">Fabricante</th>
                    <th scope="col" class="px-6 py-3">Descripción</th>
                    <th scope="col" class="px-6 py-3">Precio</th>
                    <th scope="col" class="px-6 py-3">Stock</th>
                    <th scope="col" class="px-6 py-3">Categoría</th>
                    <th scope="col" class="px-6 py-3">Vendidos</th>
                    <th scope="col" class="px-6 py-3">Fecha Agregada</th>
                    <th scope="col" class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $product->ID_producto }}</td>
                        <td class="px-6 py-4">{{ $product->nombre }}</td>
                        <td class="px-6 py-4">{{ $product->modelo }}</td>
                        <td class="px-6 py-4">{{ $product->fabricante }}</td>
                        <td class="px-6 py-4">{{ $product->descripcion }}</td>
                        <td class="px-6 py-4">{{ $product->precio }}</td>
                        <td class="px-6 py-4">{{ $product->stock }}</td>
                        <td class="px-6 py-4">{{ $product->category->nombre_categoria }}</td>
                        <td class="px-6 py-4">{{ $product->vendidos }}</td>
                        <td class="px-6 py-4">{{ $product->fecha_agregada }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('productos.edit', $product->ID_producto) }}" class="font-bold text-blue-600 dark:text-blue-500 hover:underline">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center px-6 py-4">No hay productos disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
