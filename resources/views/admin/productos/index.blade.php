@extends('admin.layouts.template')

@section('title', 'Productos')

@section('content_header')
<div class="mb-2">
    <h1 class="text-3xl font-semibold inline-block">Productos</h1>

    <!-- Barra de búsqueda -->
    <form action="{{ route('productos.index') }}" method="GET" class="inline-block ml-4 bg-white rounded-full shadow px-4">
        <input type="text" name="search" placeholder="Buscar Venta" class="border-0 focus:ring-0 focus:outline-none" value="{{ request('search') }}">
        <button type="submit" class="text-blue-500">
            Buscar
        </button>
    </form>
</div>

<!-- Filtros -->
<div class="flex justify-between items-center mb-4">
    <div class="flex space-x-4">
        <form id="filterForm" action="{{ route('productos.index') }}" method="GET" class="flex space-x-4 items-center">
            <label for="filtros" class="mr-4 text-lg font-bold">Filtrar Por</label>
            <div class="flex items-center space-x-4">
                <select name="fecha" id="fecha" class="border rounded-lg px-3 py-2 text-base font-bold w-52 truncate-text" onchange="document.getElementById('filterForm').submit();">
                    <option value="">Fecha</option>
                    <option value="asc" class="truncate-text" {{ request('fecha') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                    <option value="desc" class="truncate-text" {{ request('fecha') == 'desc' ? 'selected' : '' }}>Descendente</option>
                </select>

                <select name="precio" id="precio" class="border rounded-lg px-3 py-2 text-base font-bold w-52 truncate-text" onchange="document.getElementById('filterForm').submit();">
                    <option value="">Precio</option>
                    <option value="asc" class="truncate-text" {{ request('precio') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                    <option value="desc" class="truncate-text" {{ request('precio') == 'desc' ? 'selected' : '' }}>Descendente</option>
                </select>

                <select name="nombre" id="nombre" class="border rounded-lg px-3 py-2 text-base font-bold w-52 truncate-text" onchange="document.getElementById('filterForm').submit();">
                    <option value="">Nombre</option>
                    <option value="asc" class="truncate-text" {{ request('nombre') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                    <option value="desc" class="truncate-text" {{ request('nombre') == 'desc' ? 'selected' : '' }}>Descendente</option>
                </select>

                <select name="categoria" id="categoria" class="border rounded-lg px-3 py-2 text-base font-bold w-52 truncate-text" onchange="document.getElementById('filterForm').submit();">
                    <option value="">Categoría</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->ID_Categoria }}" class="truncate-text" {{ request('categoria') == $category->ID_Categoria ? 'selected' : '' }}>
                            {{ $category->nombre_categoria }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
        <a href="{{ route('productos.index') }}" class="text-red-500 hover:underline">
            Reiniciar Filtro
        </a>
    </div>

    <a href="{{ route('productos.create') }}" class="bg-blue-500 text-white rounded px-4 py-2">+ Agregar Producto</a>
</div>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Modelo</th>
                    <th>Fabricante</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Vendidos</th>
                    <th>Fecha Agregada</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->ID_producto }}</td>
                        <td>{{ $product->nombre }}</td>
                        <td>{{ $product->modelo }}</td>
                        <td>{{ $product->fabricante }}</td>
                        <td>{{ $product->descripcion }}</td>
                        <td>{{ $product->precio }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->category->nombre_categoria }}</td>
                        <td>{{ $product->vendidos }}</td>
                        <td>{{ $product->fecha_agregada }}</td>
                        <td>
                            <a href="{{ route('productos.edit', $product->ID_producto) }}" class="btn btn-warning btn-base">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11">No hay productos disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
</div>
@endsection
