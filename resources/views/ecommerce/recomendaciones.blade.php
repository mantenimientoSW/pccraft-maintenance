@extends('layouts.app')

@section('content')
    {{-- <h1>Recomendaciones del Mes</h1> --}}

    {{-- <h2>Fecha: {{$fechaActual}}</h2> --}}
    <section class="w-full my-24 mx-auto">
        <x-ecommerce.productos-recomendados :productosRecomendados="$productosRecomendados" />
    </section>

    {{-- !Mostrar los productos mas vendidos del mes --}}
    {{-- <table class="w-full mt-10 border text-center">
        <tr class="border border-neutral-400">
            <th class="w-1/4">ID Recomendacion</th>
            <th class="w-1/4">ID Producto</th>
            <th class="w-1/4">Nombre Producto</th>
            <th class="w-1/4">Total Vendidos</th>
        </tr>

        @foreach ($productosRecomendados as $product)
            <tr class="border border-neutral-400">
                <td>{{$product->ID_Recomendacion}}</td>
                <td>{{$product->ID_producto}}</td>
                <td>{{$product->product->nombre}}</td>
                <td>{{$product->total_vendidos}}</td>
            </tr>
        @endforeach
    </table> --}}

    {{--! Productos Recomendados --}}

    <div class="px-6 py-14">
        <div class="ml-2 mb-2">
            <h3 class="text-3xl font-semibold text-azul">Productos Recomendados</h3>
        </div>

        {{-- Wrapper Btns y Carrusel Productos --}}
        <div class="flex items-center">
            {{-- Btn Anterior --}}
            <div class="btn-anterior mr-1.5 text-neutral-500 duration-300 hover:text-azul">
                <i class="fa-solid fa-chevron-left fa-2x p-2"></i>
            </div>

            {{-- Carrusel Productos --}}
            <div class="swiper w-full">
                <!-- Contenedor Tarjetas productos -->
                <div class="swiper-wrapper py-4 pl-2.5">

                    @foreach ($productosRecomendados as $product)
                        {{-- Card Producto --}}
                        <div class="swiper-slide">
                            <div class="flex flex-col h-[25rem] py-2 pb-3 px-3 border bg-white rounded-md text-center font-medium shadow-md shadow-neutral-400 duration-300 transform transition-transform hover:scale-105">

                                {{-- Contenedor superior con imagen y detalles del producto --}}
                                <div class="grow">
                                    {{-- Imagen --}}
                                    <div class="mt-3 flex align-items items-center">
                                        <a href="{{ '/productos/' . $product->product->ID_producto }}" class="w-full h-[10.5rem] py-2">
                                            {{-- !Formatear imagen --}}
                                            <img src="{{ asset('storage/' . json_decode($product->product->url_photo, true)[0] ) }}"
                                                class="w-full h-full object-contain  rounded-xl"
                                                alt="Imagen Producto">
                                        </a>
                                    </div>
        
                                    {{-- Info Producto --}}
                                    <div>
                                        <h2 class="mt-3 mb-1">
                                            <a href="{{ '/productos/' . $product->product->ID_producto }}">
                                                <span class="duration-300 hover:text-azul">{{$product->product->nombre}}</span>
                                            </a>
                                        </h2>
                                        <p class="mb-2.5 text-sm text-verde font-normal">{{ $product->product->category->nombre_categoria }}</p>
                                        {{-- !Formatear precio --}}
                                        <div class="mb-3 flex flex-col justify-center">
                                            <p class="mb-0.5 font-['roboto'] text-sm text-base text-azul">
                                                ${{ number_format($product->precioFinal, 2, '.', ',') }}
                                            </p>
                                            @if ($product->product->descuento > 0)
                                                <p class="font-['roboto'] text-sm text-slate-400">
                                                    <span class="line-through">${{ number_format($product->product->precio, 2, '.', ',') }}</span>
                                                
                                                    <span class="py-0.5 px-1.5 font-['roboto'] text-xs text-red-600 bg-red-200 rounded-lg">
                                                        -{{ $product->product->descuento }}%
                                                    </span>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Agregar al Carrito --}}
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->product->ID_producto }}">
                                    <input type="hidden" name="nombre" value="{{ $product->product->nombre }}">
                                    <input type="hidden" name="modelo" value="{{ $product->product->modelo }}">
                                    <input type="hidden" name="fabricante" value="{{ $product->product->fabricante }}">
                                    <input type="hidden" name="descuento" value="{{ $product->product->descuento }}">
                                    <input type="hidden" name="precio" value="{{ $product->product->precio }}">
                                    <input type="hidden" name="cantidad" value="1"> 
                                    <input type="hidden" name="url_photo[]" value="{{ $product->product->url_photo }}">
                                    
                                    @error('id')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                    @error('nombre')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                    @error('modelo')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                    @error('fabricante')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                    @error('descuento')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                    @error('precio')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                    @error('cantidad')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                    @error('url_photo')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
            
                                    <button type="submit" class="w-40 mb-4 py-2 bg-white text-xs text-base font-normal border border-azul rounded-md text-azul shadow-md shadow-neutral-400 duration-500 hover:bg-azul hover:text-white hover:shadow-md hover:shadow-neutral-500">
                                        <span class="mr-2"><i class="fa-solid fa-cart-shopping"></i></span>
                                        Agregar al carrito
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Btn Next --}}
            <div class="btn-siguiente ml-4 text-neutral-500 duration-300 hover:text-azul">
                <i class="fa-solid fa-chevron-right fa-2x p-2"></i>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', (e) => {
                var swiper = new Swiper('.swiper', {
                    // Opcional
                    // direction: 'horizontal',
                    loop: true,
                    
            
                    slidesPerView: 2,
                    spaceBetween: 20,
                    navigation: {
                        nextEl: '.btn-siguiente',
                        prevEl: '.btn-anterior',
                    },
                    breakpoints: {
                        // Configura el número de productos mostrados según el tamaño de pantalla
                        320: {
                            slidesPerView: 1,
                            spaceBetween: 10
                        },
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 15
                        },
                        768: {
                            slidesPerView: 3,
                            spaceBetween: 20
                        },
                        1024: {
                            slidesPerView: 4,
                            spaceBetween: 20
                        },
                        1200: {
                            slidesPerView: 5.09,
                            spaceBetween: 25
                        }
                    }
                });
            });
        </script>
    @endpush

@endsection