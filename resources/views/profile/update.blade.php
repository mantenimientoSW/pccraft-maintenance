@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Editar Perfil') }}
    </h2>
</x-slot>

<!-- Mensajes de éxito o error -->
@if (session('status'))
    <div class="bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert">
        <p class="font-bold">{{ session('status') }}</p>
    </div>
@endif

@if ($errors->any())
    <div class="bg-red-100 border-t border-b border-red-500 text-red-700 px-4 py-3" role="alert">
        <p class="font-bold">Hubo algunos problemas con tu entrada:</p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                        <span class="ml-3 text-blue-500">Editar datos</span>
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
    
        <!-- Formulario de edición de perfil -->
        <div class="w-5/6 bg-white shadow py-10 px-12 flex justify-center">
            <div class="w-4/6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Editar Información Básica</h3>
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        Volver a perfil
                    </a>
                </div>
        
                <form method="POST" action="{{ route('profile.update.save') }}">
                    @csrf
        
                    <!-- Nombre -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
                    </div>
        
                    <!-- Apellidos -->
                    <div class="mb-4">
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Apellidos</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
                    </div>
        
                    <!-- Correo Electrónico -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
                    </div>
        
                    <!-- Teléfono Celular -->
                    <div class="mb-4">
                        <label for="cellphone" class="block text-sm font-medium text-gray-700">Teléfono Celular</label>
                        <input type="text" id="cellphone" name="cellphone" value="{{ old('cellphone', $user->cellphone) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
                    </div>
        
                    <!-- Botón Guardar Perfil -->
                    <div class="flex justify-end mb-8">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md">
                            Guardar
                        </button>
                    </div>
                </form>
        
                <!-- Formulario para actualizar contraseña -->
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Actualizar Contraseña</h3>
                <form method="POST" action="{{ route('profile.updatePassword') }}">
                    @csrf
        
                    <!-- Nueva Contraseña -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Nueva Contraseña</label>
                        <input type="password" id="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
                    </div>
        
                    <!-- Confirmar Contraseña -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
                    </div>
        
                    <!-- Botón Actualizar Contraseña -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md">
                            Actualizar
                        </button>
                    </div>
                </form>
        
                <!-- Formulario para agregar dirección -->
                <div class="mt-10 bg-white sm:rounded-lg flex-grow">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Agregar Dirección</h3>
                    <form method="POST" action="{{ route('profile.addAddress') }}">
                        @csrf
        
                        <!-- Campos del formulario de dirección -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="ciudad" class="block text-sm font-medium text-gray-700">Ciudad</label>
                                <input type="text" id="ciudad" name="ciudad" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
        
                            <div class="mb-4">
                                <label for="calle_principal" class="block text-sm font-medium text-gray-700">Calle Principal</label>
                                <input type="text" id="calle_principal" name="calle_principal" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
        
                            <div class="mb-4">
                                <label for="numero_exterior" class="block text-sm font-medium text-gray-700">Número Exterior</label>
                                <input type="text" id="numero_exterior" name="numero_exterior" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
        
                            <div class="mb-4">
                                <label for="numero_interior" class="block text-sm font-medium text-gray-700">Número Interior</label>
                                <input type="text" id="numero_interior" name="numero_interior" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
        
                            <div class="mb-4">
                                <label for="cruzamientos" class="block text-sm font-medium text-gray-700">Cruzamientos</label>
                                <input type="text" id="cruzamientos" name="cruzamientos" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
        
                            <div class="mb-4">
                                <label for="codigo_postal" class="block text-sm font-medium text-gray-700">Código Postal</label>
                                <input type="text" id="codigo_postal" name="codigo_postal" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
        
                            <div class="col-span-2 mb-4">
                                <label for="detalles" class="block text-sm font-medium text-gray-700">Detalles</label>
                                <textarea id="detalles" name="detalles" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3"></textarea>
                            </div>
                        </div>
        
                        <!-- Botón Guardar Dirección -->
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md">
                                Guardar
                            </button>
                        </div>
                    </form>
        
                    <!-- Listado de direcciones existentes -->
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4 mt-8">Tus Direcciones</h3>
        
                    @foreach($direcciones as $direccion)
                    <div class="mb-4 p-4 border border-gray-300 rounded-md {{ $direccion->is_default ? 'bg-green-100' : 'bg-white' }}">
                        <p><strong>Ciudad:</strong> {{ $direccion->ciudad }}</p>
                        <p><strong>Calle Principal:</strong> {{ $direccion->calle_principal }}</p>
                        <p><strong>Número Exterior:</strong> {{ $direccion->numero_exterior }}</p>
                        <p><strong>Cruzamientos:</strong> {{ $direccion->cruzamientos }}</p>
                        <p><strong>Código Postal:</strong> {{ $direccion->codigo_postal }}</p>
        
                        <!-- Botones para Editar y Eliminar Dirección -->
                        <div class="flex space-x-2">
                            <!-- Editar Dirección -->
                            <form action="{{ route('profile.editAddress', $direccion->ID_Direccion) }}" method="GET">
                                @csrf
                                <button type="submit" class="mt-2 px-4 py-2 bg-yellow-500 text-white rounded-md">
                                    Editar
                                </button>
                            </form>
        
                            <!-- Eliminar Dirección -->
                            <form action="{{ route('profile.deleteAddress', $direccion->ID_Direccion) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="mt-2 px-4 py-2 bg-red-500 text-white rounded-md">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection