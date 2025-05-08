@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="bg-white min-h-[47rem] flex justify-center items-center relative p-4">
    <!-- Contenedor de dos columnas con tamaño reducido -->
    <div class="flex flex-col md:flex-row w-full max-w-3xl mx-auto relative z-10">
        
        <!-- Sección de Imagen (oculta en móvil, 60% en desktop) -->
        <div class="hidden md:flex md:w-3/5 items-center justify-center rounded-t-lg md:rounded-l-lg md:rounded-tr-none">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="max-w-full max-h-full object-contain">
        </div>

        <!-- Sección del Formulario de Recuperación de Contraseña (100% en móvil, 40% en desktop) -->
        <div class="relative z-10 bg-blue-600 p-6 md:p-8 rounded-lg shadow-lg w-full md:w-2/4">
            <!-- Logo para móvil -->
            <div class="flex md:hidden justify-center mb-6">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-32 h-32 object-contain">
            </div>

            <div class="mb-4 text-sm text-gray-200 md:text-md md:leading-7">
                {{ __('¿Olvidaste tu contraseña? No hay problema. Solo ingresa tu dirección de correo electrónico y te enviaremos un enlace para restablecer tu contraseña.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-white" />
                    <x-text-input id="email" 
                                 class="block mt-1 w-full p-2 rounded-md" 
                                 type="email" 
                                 name="email" 
                                 :value="old('email')" 
                                 required 
                                 autofocus
                                 pattern="^[a-zA-Z0-9._%+-]+@(gmail\.com|hotmail\.com|alumnos\.uady\.mx)$"
                                 title="Por favor, ingrese un correo válido (gmail.com, hotmail.com, alumnos.uady.mx)" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                </div>

                <!-- Enviar botón -->
                <div class="flex items-center justify-center mt-6">
                    <x-primary-button class="w-full md:w-auto justify-center bg-blue-800 hover:bg-blue-900 text-white px-4 py-2 rounded-md">
                        {{ __('Enviar') }}
                    </x-primary-button>
                </div>

                <!-- Enlace a Inicio de Sesión -->
                <a href="{{ route('login') }}" class="flex items-center justify-center mt-4 text-sm text-gray-200 hover:text-white">
                    Ir a Inicio de Sesión
                </a>
            </form>
        </div>
    </div>
</div>
@endsection