@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="bg-white min-h-[46rem] flex justify-center items-center relative p-4">
    <!-- Contenedor de dos columnas con tamaño reducido -->
    <div class="flex flex-col md:flex-row w-full max-w-3xl mx-auto relative z-10">
        
        <!-- Sección de Imagen (oculta en móvil, visible en desktop) -->
        <div class="hidden md:flex md:w-3/5 items-center justify-center rounded-l-lg">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="max-w-full max-h-full object-contain rounded-l-lg">
        </div>

        <!-- Logo para móvil (visible en móvil, oculto en desktop) -->
        <div class="flex md:hidden w-full justify-center mb-6">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-32 h-32 object-contain">
        </div>

        <!-- Formulario de Login -->
        <form method="POST" action="{{ route('login') }}" class="relative z-10 bg-blue-600 p-6 md:p-8 rounded-lg shadow-lg w-full md:max-w-md">
            @csrf

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-white text-base md:text-base" />
                <x-text-input id="email" 
                    class="block mt-1 w-full p-2.5 md:p-2 text-base rounded-md" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username"
                    pattern="^[a-zA-Z0-9._%+-]+@(gmail\.com|hotmail\.com|alumnos\.uady\.mx)$" 
                    title="Por favor, ingrese un correo válido (gmail.com, hotmail.com, alumnos.uady.mx)" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" class="text-white text-base md:text-base" />
                <x-text-input id="password" 
                    class="block mt-1 w-full p-2.5 md:p-2 text-base rounded-md"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center text-white">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm md:text-md">{{ __('Recordar') }}</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="flex flex-col md:flex-row items-center justify-between mt-6 gap-4 md:gap-0">
                @if (Route::has('password.request'))
                    <a class="underline text-sm md:text-md text-gray-200 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white" href="{{ route('password.request') }}">
                        {{ __('Olvide la Contraseña') }}
                    </a>
                @endif

                <x-primary-button class="w-full md:w-auto justify-center bg-blue-800 hover:bg-blue-900 text-white px-6 py-2.5 rounded-md text-md">
                    {{ __('Iniciar Sesión') }}
                </x-primary-button>
            </div>

            <div class="mt-6 md:mt-4 text-center md:text-left">
                <span class="text-white text-sm md:text-md">¿No tienes cuenta?</span>
                <a href="{{ route('register') }}" class="underline text-sm md:text-md text-gray-200 font-medium hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white ml-1">
                    Regístrate aquí
                </a>
            </div>

        </form>
    </div>
</div>
@endsection