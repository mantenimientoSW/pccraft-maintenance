@extends('layouts.app')

@section('title', 'Carrito')

@section('content')
    <!-- Contenedor principal -->
    <div class="container mx-auto mt-6 mb-6 w-full lg:w-2/3">
        <!-- Título del carrito -->
        <nav aria-label="breadcrumb" class="mb-8">
            <ol class="breadcrumb flex space-x-2">
                <li class="breadcrumb-item"><a href="/" class="text-2xl font-medium text-blue-600 dark:text-white">Tienda
                        / </a></li>
                <li class="breadcrumb-item active text-2xl font-medium text-gray-900 dark:text-white" aria-current="page">
                    Carrito</li>
            </ol>
        </nav>


        @if (session()->has('success_msg'))
            <div id="alert-3"
                class="flex items-center  px-4 py-3 mb-6 text-green-800 rounded-lg bg-green-200 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium">
                    <strong>{{ session()->get('success_msg') }}</strong>
                </div>
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-green-70 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-3" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif

        @if (session()->has('errors'))
            <div id="alert-3"
                class="flex items-center px-4 py-3 mb-6 text-red-800 rounded-lg bg-red-200 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                <span class="sr-only">Error</span>
                <div class="ms-3 text-sm font-medium">
                    <strong>{{ session()->get('errors')->first() }}</strong>
                </div>
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-red-70 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-3" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif

        @if (session()->has('info_msg'))
            <div id="alert-4"
                class="flex items-center px-4 py-3 mb-6 text-yellow-800 rounded-lg bg-yellow-200 dark:bg-gray-800 dark:text-yellow-400"
                role="alert">
                <span class="sr-only">Información</span>
                <div class="ms-3 text-sm font-medium">
                    <strong>{{ session('info_msg') }}</strong>
                </div>
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-yellow-100 text-yellow-500 rounded-lg focus:ring-2 focus:ring-yellow-400 p-1.5 hover:bg-yellow-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-yellow-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-4" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
         @endif

        @if (session()->has('alert_msg'))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
                {{ session()->get('alert_msg') }}
                <button type="button" class="close absolute top-0 bottom-0 right-0 px-4 py-3" data-dismiss="alert"
                    aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ $error }}
                    <button type="button" class="close absolute top-0 bottom-0 right-0 px-4 py-3" data-dismiss="alert"
                        aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endforeach
        @endif

        @if (\Cart::getTotalQuantity() > 0)
            <h4 class="text-lg font-semibold">{{ \Cart::getTotalQuantity() }} Producto(s) en el carrito</h4><br>

            <!-- Tabla de productos -->
            <div class="bg-white shadow-md rounded my-6">
                <table class="text-left w-full border-collapse">
                    <!-- Encabezado de la tabla -->
                    <thead>
                        <tr>
                            <th
                                class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">
                                Producto</th>
                            <th
                                class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">
                                Precio</th>
                            <th
                                class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">
                                Cantidad</th>
                            <th
                                class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">
                                Total</th>
                        </tr>
                    </thead>
                    <!-- Cuerpo de la tabla -->
                    <tbody>
                        @foreach ($cartCollection as $item)
                            @php
                                $product = $products->firstWhere('ID_producto', $item->id);
                            @endphp

                            @if ($product)
                                <tr class="row">
                                    <td class="py-8 px-6 border-b border-grey-light">
                                        <div class="flex items-center">
                                            <div class="cart-pho mr-4">
                                                <a href="/productos/{{ $item->id }}" class="shrink-0">
                                                    <img src="{{ asset('storage/' . $item->attributes->image) }}"
                                                        class="img-thumbnail w-20 h-20 h-auto" alt="{{ $item->name }}">
                                                </a>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p>
                                                    <b><a href="/productos/{{ $item->id }}"
                                                            class="text-xl font-medium text-blue-700 hover:underline dark:text-white">{{ $item->name }}</a></b><br>
                                                    <b>Modelo: </b>{{ $item->attributes->model }}<br>
                                                    <b>Fabricante: </b>{{ $item->attributes->manufacturer }}<br>
                                                    <b>Stock: </b>{{ $product->stock }}

                                                <form action="{{ route('cart.remove') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" value="{{ $item->id }}" name="ID_producto">
                                                    <button
                                                        class="bg-white-600 text-red-500 hover:bg-red-200  px-2 py-1 rounded"><i
                                                            class="fa fa-trash"></i> Remover</button>
                                                </form>
                                                </p>
                                            </div>
                                        </div>
                                    </td>


                                    <td class="py-4 px-6 border-b border-grey-light">
                                        <div class="mt-5 font-['roboto'] text-lg text-green-700 font-medium">
                                            <p>${{ number_format($item->price, 2, '.', ',') }}
                                            MXN</p>
                                            @if ($item->attributes->discount > 0)
                                                <span
                                                    class="ml-1.5 text-sm text-zinc-400 line-through">${{ number_format($item->attributes->originalPrice, 2, '.', ',') }}</span>
                                                <span
                                                    class="ml-1 font-['roboto'] font-normal text-xs text-red-600 py-1.5 px-1.5 bg-red-200 rounded-xl">-{{ $item->attributes->discount }}%
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="py-4 px-6 border-b border-grey-light">
                                        <form action="{{ route('cart.update') }}" method="POST"
                                            class="flex items-center max-w-xs mx-auto">
                                            {{ csrf_field() }}
                                            <input type="hidden" value="{{ $item->id }}" id="ID_producto"
                                                name="ID_producto">
                                            <div class="relative flex items-center max-w-[8rem]">
                                                <button type="submit" name="decrement" value="1"
                                                    class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                    <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 18 2">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                                    </svg>
                                                </button>

                                                <input type="text" id="quantity-input" name="stock"
                                                    value="{{ $item->quantity }}" min="1"
                                                    max="{{ $product->stock }}"
                                                    class="bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    required disabled />

                                                <button type="submit" name="increment" value="1"
                                                    class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                    <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 18 18">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </form>
                                    </td>

                                    <td
                                        class="py-4 px-6 border-b border-grey-light mt-5 font-['roboto'] text-lg text-green-700 font-medium">
                                        ${{ number_format(Cart::get($item->id)->getPriceSum(), 2, '.', ',') }} MXN
                                    </td>
                            @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if (count($cartCollection) > 0)
                <div class="flex justify-start mt-6">
                    <form action="{{ route('cart.clear') }}" method="POST">
                        {{ csrf_field() }}
                        <button class="btn bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-500"">Vaciar
                            Carrito</button>
                    </form>
                </div>
            @endif

<!-- Aqui se redirige a pago -->
<div class="flex justify-end mt-6 space-y-4">
    <div class="text-right">
        <div class="text-xl font-bold mb-4">
            Total a pagar: ${{ number_format(Cart::getTotal(), 2, '.', ',') }} MXN
        </div>
        
        <!-- Formulario para procesar el pago con Stripe -->
        <form action="{{ route('checkout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 mt-4 mb-4">
                Ir a pagar
            </button>
        </form>

        <!-- Mostrar mensajes de error -->
        @if (session('error'))
            <div class="mt-4 p-4 bg-red-100 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

    </div>
</div>







</form>

            </div>
    </div>
@else
    <h4 class="text-lg font-semibold">No hay Producto(s) en el Carrito</h4><br>
    <a href="/" class="btn bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-500">Continuar en la tienda</a>
    @endif

    </section>

@endsection


