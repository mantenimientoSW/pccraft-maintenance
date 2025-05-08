@extends('layouts.app')

@section('title', 'Home')

@section('content')
<x-guest-layout>
    <div class="m-4">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-32 h-32 object-contain">
        </div>

        <div>
            <h1 class="md:text-lg font-semibold text-center">Restablecer Contraseña</h1>
        </div>
    
        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf
    
            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
    
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" 
                             class="block mt-1 w-full" 
                             type="email" 
                             name="email" 
                             :value="old('email', $request->email)" 
                             required 
                             autofocus 
                             autocomplete="username"
                             pattern="^[a-zA-Z0-9._%+-]+@(gmail\.com|hotmail\.com|alumnos\.uady\.mx)$"
                             title="Por favor, ingrese un correo válido (gmail.com, hotmail.com, alumnos.uady.mx)" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
    
            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" />
                <x-text-input id="password" 
                             class="block mt-1 w-full" 
                             type="password" 
                             name="password" 
                             required 
                             autocomplete="new-password"
                             minlength="8" 
                             maxlength="16" 
                             title="La contraseña debe tener entre 8 y 16 caracteres." />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
    
            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                <x-text-input id="password_confirmation" 
                             class="block mt-1 w-full"
                             type="password"
                             name="password_confirmation" 
                             required 
                             autocomplete="new-password"
                             minlength="8" 
                             maxlength="16" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
    
            <div class="flex flex-col sm:flex-row items-center justify-right mt-6 gap-4">
                <x-primary-button class="w-full sm:w-auto justify-center">
                    {{ __('Restablecer Contraseña') }}
                </x-primary-button>
    
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 w-full sm:w-auto text-center">
                    Ir a Inicio de Sesión
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
@endsection