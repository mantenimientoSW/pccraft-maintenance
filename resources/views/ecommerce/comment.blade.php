@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Título del producto dinámico -->
    <h1 class="text-2xl lg:text-3xl font-bold mb-6">{{ $producto->nombre }}</h1>
    
    <!-- Contenedor para el título de detalles de la orden -->
    <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg mb-6">
        <h2 class="text-lg lg:text-xl font-semibold">Detalles de la orden</h2>
    </div>

    <!-- Contenedor flex para detalles y imagen -->
    <div class="flex flex-col lg:flex-row gap-6 mb-8 items-center">
        <!-- Detalles de la orden -->
        <div class="w-full lg:w-2/3">
            <div class="border border-gray-300 p-6 rounded-lg h-full flex items-center">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full">
                    <!-- Fechas -->
                    <div>
                        <p class="mb-4 text-base lg:text-lg"><strong>Pedido:</strong> {{ \Carbon\Carbon::parse($order->agregada)->format('d/m/Y') }}</p>
                        <p class="mb-4 text-base lg:text-lg"><strong>Enviado:</strong> {{ \Carbon\Carbon::parse($order->fecha_enviado)->format('d/m/Y H:i') }}</p>
                        <p class="text-base lg:text-lg"><strong>Entregado:</strong> {{ \Carbon\Carbon::parse($order->fecha_entregado)->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <!-- Orden e ID -->
                    <div>
                        <p class="text-2xl lg:text-3xl font-bold mb-4">Orden: #{{ $order->ID_Orden }}</p>
                        <p class="text-gray-500 text-sm"><strong>ID del producto:</strong> {{ $producto->pivot->ID_Producto }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Imagen del producto -->
        <div class="w-full lg:w-1/3 flex justify-center">
            @if($producto->url_photo)
                <div class="flex justify-center items-center">
                    <img src="{{ asset('storage/' . json_decode($producto->url_photo, true)[0] ) }}" 
                         alt="{{ $producto->nombre }}" 
                         class="w-60 h-60 lg:w-72 lg:h-72 object-contain">
                </div>
            @else
                <span>No disponible</span>
            @endif
        </div>
    </div>

    <!-- Formulario de reseña -->
    <div class="mt-8">
        <form action="{{ route('comment.index', ['orderId' => $order->ID_Orden, 'productId' => $producto->pivot->ID_Producto]) }}" 
              method="POST">
            @csrf
            <div class="mb-6">
                <label for="title" class="block text-base lg:text-lg font-medium text-gray-700">Título</label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       class="mt-2 w-full p-3 border border-gray-300 rounded-lg" 
                       placeholder="Opcional: introduce un título" 
                       value="{{ old('title', $review->titulo ?? '') }}">
            </div>

            <div class="mb-6">
                <label for="rating" class="block text-base lg:text-lg font-medium text-gray-700 mb-2">Calificación *</label>
                <div class="flex items-center">
                    @for ($i = 1; $i <= 5; $i++)
                        <input type="radio" 
                               name="rating" 
                               value="{{ $i }}" 
                               id="rating{{ $i }}" 
                               class="hidden rating-star" 
                               {{ (isset($review) && $review->calificacion == $i) ? 'checked' : '' }}>
                        <label for="rating{{ $i }}" 
                               class="cursor-pointer text-3xl lg:text-4xl mr-2 {{ (isset($review) && $review->calificacion >= $i) ? 'text-blue-500' : 'text-gray-400' }} hover:text-blue-500">&#9733;</label>
                    @endfor
                </div>
            </div>

            <div class="mb-6">
                <label for="review" class="block text-base lg:text-lg font-medium text-gray-700 mb-2">¿Qué te pareció? *</label>
                <textarea name="review" 
                          id="review" 
                          rows="4" 
                          class="mt-2 w-full p-3 border border-gray-300 rounded-lg" 
                          placeholder="Opcional: ¿Puedes describir la razón de tu calificación?">{{ old('review', $review->comentario ?? '') }}</textarea>
            </div>

            <div class="mb-4 text-sm text-red-500">
                Los campos marcados con * son obligatorios
            </div>

            <div>
                <button type="submit" 
                        class="w-full sm:w-auto px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600">
                    Publicar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.rating-star');
        const labels = document.querySelectorAll('label[for^="rating"]');

        labels.forEach((label, index) => {
            label.addEventListener('click', function () {
                labels.forEach(lbl => {
                    lbl.classList.remove('text-blue-500');
                    lbl.classList.add('text-gray-400');
                });

                for (let i = 0; i <= index; i++) {
                    labels[i].classList.remove('text-gray-400');
                    labels[i].classList.add('text-blue-500');
                }
            });
        });
    });
</script>

@endsection
