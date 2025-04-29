@extends('layouts.app')

@section('title', 'Mi Cuenta')

@section('content')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Mi Cuenta') }}
    </h2>
</x-slot>

<!-- Aumentar el ancho máximo del contenedor principal -->
<div class="w-full flex justify-center">
    {{-- Wrapper --}}
    <div class="px-2 w-full flex">
        <!-- Sidebar (Fijo a la izquierda) -->
        <div class="w-1/6 bg-slate-50 shadow">
            <ul class="mt-16 space-y-28 pr-6">
                <li class="flex justify-end">
                    <a href="{{ route('profile.update') }}" class="px-2 flex items-center text-gray-900 rounded-lg hover:text-azul duration-500 group">
                        <!-- Icono de edición (Heroicon) -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                        <span class="ml-3">Editar datos</span>
                    </a>
                </li>
                <li class="flex justify-end">
                    <a href="{{ route('user.orders.index') }}" class="px-2 flex items-center text-gray-900 rounded-lg hover:text-azul duration-500 group">
                        <!-- Icono de compras (Heroicon) -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        <span class="ml-3">Ver compras</span>
                    </a>
                </li>
                <li class="flex justify-end">
                    <form method="POST" action="{{ route('logout') }}" class="px-2 flex items-center text-gray-900 rounded-lg hover:text-azul duration-500 group">
                        @csrf
                        <!-- Icono de logout (Heroicon) -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                        </svg>
                        <button type="submit" class="ml-3 text-left">
                            Cerrar sesión
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    
        <!-- Vista del perfil (contenido no editable) -->
        <div class="w-5/6 bg-white shadow py-10 px-12 flex justify-center">
            <div class="w-4/6">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Información Básica</h3>
        
                <!-- Nombre (No editable) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <p class="mt-1 min-h-10 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-100">
                        {{ auth()->user()->name }}
                    </p>
                </div>
        
                <!-- Apellidos (No editable) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Apellidos</label>
                    <p class="mt-1 min-h-10 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-100">
                        {{ auth()->user()->last_name }}
                    </p>
                </div>
        
                <!-- Correo Electrónico (No editable) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <p class="mt-1 min-h-10 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-100">
                        {{ auth()->user()->email }}
                    </p>
                </div>
        
                <!-- Teléfono Celular (No editable) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Teléfono Celular</label>
                    <p class="mt-1 min-h-10 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-100">
                        {{ auth()->user()->cellphone }}
                    </p>
                </div>
        
                <!-- Direcciones -->
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Tus Direcciones</h3>
        
                @foreach($direcciones as $direccion)
                    <div class="mb-4 p-4 border border-gray-300 rounded-md {{ $direccion->is_default ? 'bg-green-100' : 'bg-white' }}">
                        <p><strong>Ciudad:</strong> {{ $direccion->ciudad }}</p>
                        <p><strong>Calle Principal:</strong> {{ $direccion->calle_principal }}</p>
                        <p><strong>Número Exterior:</strong> {{ $direccion->numero_exterior }}</p>
                        <p><strong>Número Interior:</strong> {{ $direccion->numero_interior }}</p>
                        <p><strong>Cruzamientos:</strong> {{ $direccion->cruzamientos }}</p>
                        <p><strong>Detalles:</strong> {{ $direccion->detalles }}</p>
                        <p><strong>Código Postal:</strong> {{ $direccion->codigo_postal }}</p>
        
                        <!-- Botón para seleccionar la dirección como predeterminada -->
                        @if(!$direccion->is_default)
                        <form action="{{ route('profile.setDefaultAddress', $direccion->ID_Direccion) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-md">
                                Marcar como Predeterminada
                            </button>
                        </form>
                        @else
                        <p class="mt-2 px-4 py-2 bg-green-500 text-white rounded-md">
                            Dirección Predeterminada
                        </p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
