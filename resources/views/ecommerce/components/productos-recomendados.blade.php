<div class="px-6">
    <div class="mb-6 text-center">
        <h3 class="text-4xl font-semibold text-azul">Productos Destacados</h3>
        <p class="mt-5 font-medium text-neutral-700">Los productos más vendidos del último mes</p>
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
                <div class="swiper-slide">
                        {{-- Card Producto --}}
                        <div class="flex flex-col h-[26rem] py-2 pb-3 px-3 border bg-white rounded-md text-center font-medium shadow-md shadow-neutral-400 duration-300 transform transition-transform hover:scale-105">

                            {{-- Imagen --}}
                            <div class="mt-2 flex align-items items-center">
                                <a href="{{ '/productos/' . $product->product->ID_producto }}" class="w-full h-[10.5rem] py-2">
                                    <img src="{{ asset('storage/' . json_decode($product->product->url_photo, true)[0] ) }}"
                                        class="w-full h-full object-contain  rounded-xl"
                                        alt="Imagen Producto">
                                </a>
                            </div>

                            {{-- Contenedor Nombre, Categoria y Precio --}}
                            <div class="grow flex flex-col">
                                {{-- Nombre y Categoria --}}
                                <div class="grow flex flex-col justify-evenly">
                                    <h2 class="mt-1">
                                        <a href="{{ '/productos/' . $product->product->ID_producto }}">
                                            <span class="duration-300 hover:text-azul">{{$product->product->nombre}}</span>
                                        </a>
                                    </h2>
                                    <p class="justify-center text-sm text-verde font-medium">{{ $product->product->category->nombre_categoria }}</p>
                                </div>
                                
                                {{-- Precio y Descuento --}}
                                <div class="mt-1 mb-3 flex flex-col justify-center">
                                    <p class="mb-0.5 font-['roboto'] text-base text-azul">
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
        
                                <div class="px-4">
                                    <button type="submit" class="w-full mb-3 py-2 bg-white text-[0.85rem] font-normal border border-azul rounded-md text-azul shadow-md shadow-neutral-400 duration-500 hover:bg-azul hover:text-white hover:shadow-md hover:shadow-neutral-500">
                                        <span class="mr-2"><i class="fa-solid fa-cart-shopping"></i></span>
                                        Agregar al carrito
                                    </button>
                                </div>
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