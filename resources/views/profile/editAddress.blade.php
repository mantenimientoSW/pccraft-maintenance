@extends('layouts.app')

@section('title', 'Editar Dirección')

@section('content')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Editar Dirección') }}
    </h2>
</x-slot>

<div class="flex max-w-6xl w-full space-x-20">
    <!-- Sidebar (Fijo a la izquierda) -->
    <div class="bg-gray-50 shadow sm:rounded-lg p-6" style="flex: 0 0 450px;">
    <ul class="space-y-4">
        <li>
            <a href="{{ route('profile.update') }}" class="flex items-center text-gray-700 hover:underline">
                <!-- Ícono de "flecha hacia la izquierda" (Heroicon) -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
                <!-- Texto del enlace -->
                <span class="ml-3">Volver a direcciones</span>
            </a>
        </li>
    </ul>
</div>
    

    <!-- Formulario de edición de dirección -->
    <div class="bg-white shadow sm:rounded-lg p-6 justify-center w-3/4" style="flex: 0 0 800px;">
        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Editar Dirección</h3>

        <form method="POST" action="{{ route('profile.updateAddress', $direccion->ID_Direccion) }}">
            @csrf
            @method('PATCH')

            <!-- Ciudad -->
            <div class="mb-4">
                <label for="ciudad" class="block text-sm font-medium text-gray-700">Ciudad</label>
                <input type="text" id="ciudad" name="ciudad" value="{{ old('ciudad', $direccion->ciudad) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
            </div>

            <!-- Calle Principal -->
            <div class="mb-4">
                <label for="calle_principal" class="block text-sm font-medium text-gray-700">Calle Principal</label>
                <input type="text" id="calle_principal" name="calle_principal" value="{{ old('calle_principal', $direccion->calle_principal) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
            </div>

            <!-- Cruzamientos -->
            <div class="mb-4">
                <label for="cruzamientos" class="block text-sm font-medium text-gray-700">Cruzamientos</label>
                <input type="text" id="cruzamientos" name="cruzamientos" value="{{ old('cruzamientos', $direccion->cruzamientos) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
            </div>

            <!-- Número Exterior -->
            <div class="mb-4">
                <label for="numero_exterior" class="block text-sm font-medium text-gray-700">Número Exterior</label>
                <input type="text" id="numero_exterior" name="numero_exterior" value="{{ old('numero_exterior', $direccion->numero_exterior) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
            </div>

            <!-- Número Interior -->
            <div class="mb-4">
                <label for="numero_interior" class="block text-sm font-medium text-gray-700">Número Interior</label>
                <input type="text" id="numero_interior" name="numero_interior" value="{{ old('numero_interior', $direccion->numero_interior) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
            </div>

            <!-- Detalles -->
            <div class="mb-4">
                <label for="detalles" class="block text-sm font-medium text-gray-700">Detalles</label>
                <textarea id="detalles" name="detalles" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">{{ old('detalles', $direccion->detalles) }}</textarea>
            </div>

            <!-- Código Postal -->
            <div class="mb-4">
                <label for="codigo_postal" class="block text-sm font-medium text-gray-700">Código Postal</label>
                <input type="text" id="codigo_postal" name="codigo_postal" value="{{ old('codigo_postal', $direccion->codigo_postal) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-2 px-3">
            </div>

            <!-- Botón Guardar -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection