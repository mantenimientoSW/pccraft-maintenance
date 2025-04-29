@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="bg-white min-h-screen flex justify-center items-center relative">
    <!-- Contenedor de dos columnas con tamaño reducido -->
    <div class="flex w-full max-w-3xl mx-auto relative z-10">
        
        <!-- Sección de Imagen (60%) -->
        <div class="w-3/5 flex items-center justify-center rounded-l-lg">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="max-w-full max-h-full object-contain rounded-l-lg">
        </div>

        <!-- Sección del Formulario de Recuperación de Contraseña (40%) -->
        <div class="relative z-10 bg-blue-600 p-8 rounded-lg shadow-lg w-2/4">
            <div class="mb-4 text-sm text-gray-200">
                {{ __('¿Olvidaste tu contraseña? No hay problema. Solo ingresa tu dirección de correo electrónico y te enviaremos un enlace para restablecer tu contraseña.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-white" />
                    <x-text-input id="email" class="block mt-1 w-full p-2 rounded-md" type="email" name="email" :value="old('email')" required autofocus
                        pattern="^[a-zA-Z0-9._%+-]+@(gmail\.com|hotmail\.com|alumnos\.uady\.mx)$"
                        title="Por favor, ingrese un correo válido (gmail.com, hotmail.com, alumnos.uady.mx)" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                </div>

                <!-- Enviar botón -->
                <div class="flex items-center justify-center mt-6">
                    <x-primary-button class="bg-blue-800 hover:bg-blue-900 text-white px-4 py-2 rounded-md">
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
