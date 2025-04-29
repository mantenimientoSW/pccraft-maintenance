<!-- resources/views/checkout/cancel.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mx-auto max-w-2xl mt-20 p-8 bg-white rounded-lg shadow-lg text-center">
        <h1 class="text-3xl font-semibold text-red-600 mb-4">El pago fue cancelado</h1>

        @if (session('error'))
            <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-600 rounded-md">
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('cart.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white font-medium text-lg rounded-md shadow hover:bg-blue-700 transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                Volver al carrito
            </a>
        </div>
    </div>
@endsection
