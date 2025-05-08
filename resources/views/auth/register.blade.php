@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="bg-white min-h-[46rem] flex justify-center items-center relative p-4">
    <!-- Contenedor de dos columnas con tamaño reducido -->
    <div class="flex flex-col md:flex-row w-full max-w-3xl mx-auto relative z-10">
        
        <!-- Sección de Imagen (oculta en móvil, 60% en desktop) -->
        <div class="hidden md:flex md:w-3/5 items-center justify-center rounded-l-lg">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="max-w-full max-h-full object-contain rounded-l-lg">
        </div>

        <!-- Sección del Formulario (100% en móvil, 40% en desktop) -->
        <form method="POST" action="{{ route('register') }}" class="relative z-10 bg-blue-600 p-6 md:p-8 rounded-lg shadow-lg w-full md:w-2/4">
            @csrf

            <!-- Logo para móvil -->
            <div class="flex md:hidden justify-center mb-6">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-32">
            </div>

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nombre')" class="text-white" />
                <x-text-input id="name" class="block mt-1 w-full p-2 rounded-md text-base" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
            </div>

            <!-- Last Name (Apellidos) -->
            <div class="mt-4">
                <x-input-label for="last_name" :value="__('Apellidos')" class="text-white" />
                <x-text-input id="last_name" class="block mt-1 w-full p-2 rounded-md text-base" type="text" name="last_name" :value="old('last_name')" required />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2 text-red-500" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" class="text-white" />
                <x-text-input id="email" class="block mt-1 w-full p-2 rounded-md text-base" type="email" name="email" :value="old('email')" required autocomplete="username"
                    pattern="^[a-zA-Z0-9._%+-]+@(gmail\.com|hotmail\.com|alumnos\.uady\.mx)$" title="Por favor, ingrese un correo válido (gmail.com, hotmail.com, alumnos.uady.mx)" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" class="text-white" />
                <x-text-input id="password" class="block mt-1 w-full p-2 rounded-md text-base"
                              type="password"
                              name="password"
                              required autocomplete="new-password"
                              minlength="8" maxlength="16" title="La contraseña debe tener entre 8 y 16 caracteres." />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-white" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full p-2 rounded-md text-base"
                              type="password"
                              name="password_confirmation" required autocomplete="new-password"
                              minlength="8" maxlength="16" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col md:flex-row items-center justify-between mt-6 gap-4 md:gap-0">
                <a class="text-sm text-gray-200 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white underline" href="{{ route('login') }}">
                    {{ __('¿Ya está registrado?') }}
                </a>

                <x-primary-button class="w-full md:w-auto bg-blue-800 hover:bg-blue-900 justify-center text-white px-4 py-2 rounded-md">
                    {{ __('Registrar') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection