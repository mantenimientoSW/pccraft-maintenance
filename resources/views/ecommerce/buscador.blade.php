@extends('layouts.app')

@section('title', 'Buscador')

@section('content')
    <div class="w-full flex justify-center bg-stone-50">
        <div class="w-11/12 mt-5 mb-8 flex flex-col md:flex-row justify-center gap-4">

            {{-- Seccion de Filtros --}}
            <div class="w-full md:w-2/12 max-h-fit pt-3 px-6 pb-7 bg-white border-2 rounded-lg shadow-lg text-sm">
                {{-- Formulario Filtros --}}
                <div class="mt-2">
                    <h2 class="text-xl md:text-2xl text-azul font-semibold">Filtros</h2>
                    <form id="filterForm" method="GET">
                        {{-- Ordenar --}}
                        <div class="mt-1.5 flex flex-col gap-2">
                            <label for="order-by" class="text-base md:text-lg font-medium">Ordenar por</label>
                            <select name="order-by" 
                                id="order-by" 
                                class="w-full text-xs text-neutral-800 rounded" 
                                onchange="document.getElementById('filterForm').submit();">

                                @if ( empty( request('order-by') ) || is_null( request('order-by') ) )
                                    <option class="text-neutral-500" value="" selected disabled>-- Seleccionar filtro --</option>
                                @endif
                                <option class="text-black" value="cheaper" {{ request('order-by') == 'cheaper' ? 'selected' : '' }} >Menor a mayor precio</option>
                                <option class="text-black" value="more-expensive" {{  request('order-by') == 'more-expensive' ? 'selected' : '' }}>Mayor a menor precio</option>
                                <option class="text-black" value="newest" {{ request('order-by') == 'newest' ? 'selected' : '' }}>Más recientes</option>
                                <option class="text-black" value="lessnew" {{ request('order-by') == 'lessnew' ? 'selected' : '' }}>Menos recientes</option>
                            </select>
                        </div>

                        {{-- Rango de Precio --}}
                        <div class="mt-3 flex flex-col">
                            <h3 class="text-base md:text-lg font-medium">Precio</h3>
                            <div class="mt-0.5 flex flex-col">
                                <label for="min-price">Precio Mínimo</label>
                                <input class="mt-0.5 text-xs rounded" type="number" name="min-price" id="min-price" min="0" value="{{ $minPrice }}">
                            </div>
                            <div class="mt-1.5 flex flex-col">
                                <label for="max-price">Precio Máximo</label>
                                <input class="mt-0.5 py-2 text-xs rounded" type="number" name="max-price" id="max-price" min="0" value="{{ $maxPrice }}">
                            </div>
                            {{-- Alerta --}}
                            <div id="alerta-precioMin-incorrecto" class="hidden duration-500 mt-3 flex items-center p-3 border border-red-200 text-red-800 rounded-lg bg-red-50 text-sm hover:bg-red-400 hover:text-white" role="alert">
                                <span class="sr-only">Info</span>
                                <div class="ms-3 text-xs">
                                    El valor del precio mínimo debe ser <span class="font-semibold">menor</span> que el valor del precio máximo.
                                </div>
                            </div>
                        </div>

                        {{--  !Campo de búsqueda por nombre/modelo --}}
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        
                        {{-- Boton Aplicar filtros y Reset Filtros--}}
                        <div class="mt-4 flex flex-col justify-center gap-3">
                            <button type="submit" id="btn-submit-filterForm" class="w-full py-2 px-4 bg-white text-sm border border-azul rounded-lg text-azul shadow hover:shadow-xl duration-500 hover:bg-azul hover:text-white">
                                <i class="fa-solid fa-filter"></i>
                                <span>Aplicar Filtros</span>
                            </button>
                            <a href="{{route('productos.buscador')}}" class="w-full py-2 px-4 bg-white text-sm text-center border border-azul rounded-lg text-azul shadow duration-500 hover:shadow-xl hover:bg-azul hover:text-white">
                                <i class="fa-solid fa-rotate-left"></i>
                                <span>Reestablecer Filtros</span>
                            </a>
                        </div>
                    </form>
                </div>

                {{-- Categorias con botón para mostrar/ocultar en móvil --}}
                <div class="mt-6 flex flex-col">
                    <button id="toggleCategorias" class="flex items-center justify-between w-full mb-2.5 text-lg md:text-xl font-medium md:cursor-default bg-white">
                        <span>Categorías</span>
                        <i class="fa-solid fa-chevron-down md:hidden transition-transform duration-300"></i>
                    </button>
                    <div id="categoriasContainer" class="hidden md:flex flex-col text-center gap-3">
                        <div class="grid grid-cols-2 md:grid-cols-1 gap-2 md:gap-3">
                            <a href="{{ route('productos.categorias', 'procesador') }}" 
                                class="py-2 md:py-2.5 px-3 md:px-4 text-sm md:text-base border border-azul rounded-lg text-azul shadow shadow-neutral-300 duration-500 hover:shadow hover:shadow-neutral-800 hover:bg-azul hover:text-white
                                {{ url()->current() === route('productos.categorias', 'procesador') ? 'bg-azul text-white font-medium' : '' }}"
                            >Procesadores</a>

                            <a href="{{ route('productos.categorias', 'tarjeta de video') }}" 
                                class="py-2 md:py-2.5 px-3 md:px-4 text-sm md:text-base border border-azul rounded-lg text-azul shadow shadow-neutral-300 duration-500 hover:shadow hover:shadow-neutral-800 hover:bg-azul hover:text-white 
                                {{ url()->current() === route('productos.categorias', 'tarjeta de video') ? 'bg-azul text-white font-medium' : '' }}"
                            >Tarjetas de Vídeo</a>

                            <a href="{{ route('productos.categorias', 'tarjeta madre') }}" 
                                class="py-2 md:py-2.5 px-3 md:px-4 text-sm md:text-base border border-azul rounded-lg text-azul shadow shadow-neutral-300 duration-500 hover:shadow hover:shadow-neutral-800 hover:bg-azul hover:text-white 
                                {{ url()->current() === route('productos.categorias', 'tarjeta madre') ? 'bg-azul text-white font-medium' : '' }}"
                            >Tarjetas Madre</a>

                            <a href="{{ route('productos.categorias', 'memoria ram') }}" 
                                class="py-2 md:py-2.5 px-3 md:px-4 text-sm md:text-base border border-azul rounded-lg text-azul shadow shadow-neutral-300 duration-500 hover:shadow hover:shadow-neutral-800 hover:bg-azul hover:text-white 
                                {{ url()->current() === route('productos.categorias', 'memoria ram') ? 'bg-azul text-white font-medium' : '' }}"
                            >Memorias RAM</a>

                            <a href="{{ route('productos.categorias', 'disco duro') }}" 
                                class="py-2 md:py-2.5 px-3 md:px-4 text-sm md:text-base border border-azul rounded-lg text-azul shadow shadow-neutral-300 duration-500 hover:shadow hover:shadow-neutral-800 hover:bg-azul hover:text-white 
                                {{ url()->current() === route('productos.categorias', 'disco duro') ? 'bg-azul text-white font-medium' : '' }}"
                            >Discos Duros</a>

                            <a href="{{ route('productos.categorias', 'gabinete') }}" 
                                class="py-2 md:py-2.5 px-3 md:px-4 text-sm md:text-base border border-azul rounded-lg text-azul shadow shadow-neutral-300 duration-500 hover:shadow hover:shadow-neutral-800 hover:bg-azul hover:text-white 
                                {{ url()->current() === route('productos.categorias', 'gabinete') ? 'bg-azul text-white font-medium' : '' }}"
                            >Gabinetes</a>

                            <a href="{{ route('productos.categorias', 'accesorios') }}" 
                                class="py-2 md:py-2.5 px-3 md:px-4 text-sm md:text-base border border-azul rounded-lg text-azul shadow shadow-neutral-300 duration-500 hover:shadow hover:shadow-neutral-800 hover:bg-azul hover:text-white 
                                {{ url()->current() === route('productos.categorias', 'accesorios') ? 'bg-azul text-white font-medium' : '' }}"
                            >Accesorios</a>

                            <a href="{{ route('productos.categorias', 'fuente de poder') }}" 
                                class="py-2 md:py-2.5 px-3 md:px-4 text-sm md:text-base border border-azul rounded-lg text-azul shadow shadow-neutral-300 duration-500 hover:shadow hover:shadow-neutral-800 hover:bg-azul hover:text-white 
                                {{ url()->current() === route('productos.categorias', 'fuente de poder') ? 'bg-azul text-white font-medium' : '' }}"
                            >Fuentes de poder</a>

                            <a href="{{ route('productos.categorias', 'enfriamiento') }}" 
                                class="py-2 md:py-2.5 px-3 md:px-4 text-sm md:text-base border border-azul rounded-lg text-azul shadow shadow-neutral-300 duration-500 hover:shadow hover:shadow-neutral-800 hover:bg-azul hover:text-white 
                                {{ url()->current() === route('productos.categorias', 'enfriamiento') ? 'bg-azul text-white font-medium' : '' }}"
                            >Enfriamiento</a>
                        </div>
                    </div>
                </div>

            </div>
        
            {{-- Seccion de Resultados --}}
            <div class="w-full md:w-10/12 md:ml-5">
                @if ($productToSearch)
                    <div class="mb-7">
                        <h1 class="text-xl md:text-2xl font-semibold text-azul">{{$products->total()}} Resultados para "{{$productToSearch}}"</h1>
                    </div>
                @endif
                
                {{-- Verificar si hay productos para mostrar --}}
                @if ( count( $products ) === 0 )
                    {{-- Si no hay productos --}}
                    <div class="mt-12 md:mt-24 flex flex-col gap-6 items-center justify-center">
                        <h3 class="font-medium text-lg md:text-xl text-neutral-500">No hay productos para mostrar</h3>
                        <img src="{{asset('img/no_results.png')}}" 
                            alt="Imagen Sin Resultados"
                            class="h-[20rem] md:h-[28rem]">
                    </div>
                @else
                    {{-- Lista de productos --}}
                    <div class="w-full py-4 md:py-6 px-4 md:px-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 bg-white border-2 border-gray-200 rounded-lg shadow-lg">
                        {{-- Mostrar los productos --}}
                        @foreach ($products as $product)
                            <div class="flex flex-col px-3 border border-neutral-200 bg-white rounded-md text-center font-medium shadow-md shadow-neutral-300 duration-300 hover:shadow-neutral-400">

                                {{-- Imagen --}}
                                <div class="px-1 flex align-items items-center">
                                    <a href="{{ '/productos/' . $product->ID_producto }}" class="w-full h-[10rem] sm:h-[13rem] py-3">
                                        {{-- !Formatear imagen --}}
                                        <img src="{{ asset('storage/' . json_decode($product->url_photo, true)[0] ) }}"
                                            class="w-full h-full object-contain  rounded-xl"
                                            alt="Imagen Producto">
                                    </a>
                                </div>

                                {{-- Contenedor Nombre, Categoria y Precio --}}
                                <div class="grow flex flex-col">
                                    {{-- Nombre y Categoria --}}
                                    <div class="grow flex flex-col justify-evenly">
                                        <h2 class="mt-2 md:mt-3 text-sm md:text-base">
                                            <a href="{{ '/productos/' . $product->ID_producto }}">
                                                <span class="duration-300 hover:text-azul">{{$product->nombre}}</span>
                                            </a>
                                        </h2>
                                        <p class="mb-1.5 text-sm text-verde font-medium">{{ $product->category->nombre_categoria }}</p>
                                    </div>

                                    {{-- Precio y Descuento --}}
                                    <div class="mt-1 mb-3 flex flex-col justify-center text-sm">
                                        <p class="mb-0.5 font-['roboto'] text-base text-azul">
                                            ${{ number_format($product->precioFinal, 2, '.', ',') }}
                                        </p>
                                        @if ($product->descuento > 0)
                                            <p class="font-['roboto'] text-sm text-slate-400">
                                                <span class="line-through">${{ number_format($product->precio, 2, '.', ',') }}</span>
                                            
                                                <span class="py-0.5 px-1.5 font-['roboto'] font-medium text-xs text-red-600 bg-red-200 rounded-lg">
                                                    -{{ $product->descuento }}%
                                                </span>
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Agregar al Carrito --}}
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->ID_producto }}">
                                    <input type="hidden" name="nombre" value="{{ $product->nombre }}">
                                    <input type="hidden" name="modelo" value="{{ $product->modelo }}">
                                    <input type="hidden" name="fabricante" value="{{ $product->fabricante }}">
                                    <input type="hidden" name="descuento" value="{{ $product->descuento }}">
                                    <input type="hidden" name="precio" value="{{ $product->precio }}">
                                    <input type="hidden" name="cantidad" value="1"> 
                                    <input type="hidden" name="url_photo[]" value="{{ $product->url_photo }}">
                                    
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
                                        <button type="submit" class="w-full mb-5 py-2.5 bg-white text-[0.85rem] font-normal border border-azul rounded-md text-azul shadow-md shadow-neutral-400 duration-500 hover:bg-azul hover:text-white hover:shadow-md hover:shadow-neutral-500">
                                            <span class="mr-2"><i class="fa-solid fa-cart-shopping"></i></span>
                                            Agregar al carrito
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Menu Paginacion --}}
                <div class="mt-6 md:mt-8 px-4 md:px-0">
                    @if($products->hasPages())
                        <div class="flex flex-col md:flex-row items-center gap-4 md:justify-between">
                            {{-- Botón Anterior --}}
                            @if($products->onFirstPage())
                                <span class="w-full md:w-auto px-4 py-2 text-center text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">Anterior</span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}" class="w-full md:w-auto px-4 py-2 text-center text-azul bg-white border border-azul rounded-lg hover:bg-azul hover:text-white transition-colors duration-300">
                                    Anterior
                                </a>
                            @endif

                            {{-- Número de página actual --}}
                            <span class="text-sm text-gray-700">
                                Página {{ $products->currentPage() }} de {{ $products->lastPage() }}
                            </span>

                            {{-- Botón Siguiente --}}
                            @if($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}" class="w-full md:w-auto px-4 py-2 text-center text-azul bg-white border border-azul rounded-lg hover:bg-azul hover:text-white transition-colors duration-300">
                                    Siguiente
                                </a>
                            @else
                                <span class="w-full md:w-auto px-4 py-2 text-center text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">Siguiente</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Validación de precio existente
    document.addEventListener('DOMContentLoaded', (e) => {
        validarCampoPrecio();
        setupCategoriasToggle();
    });

    function setupCategoriasToggle() {
        const toggleBtn = document.getElementById('toggleCategorias');
        const container = document.getElementById('categoriasContainer');
        const icon = toggleBtn.querySelector('i');

        // En desktop, mostrar siempre las categorías
        if (window.innerWidth >= 768) {
            container.classList.remove('hidden');
            return;
        }

        toggleBtn.addEventListener('click', () => {
            container.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        });

        // Manejar cambios de tamaño de ventana
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                container.classList.remove('hidden');
            } else if (!container.classList.contains('hidden')) {
                container.classList.add('hidden');
            }
        });
    }

    // Código existente de validación de precio
    function validarCampoPrecio() {
        const precioMin = document.getElementById('min-price');
        const precioMax = document.getElementById('max-price');

        precioMin.addEventListener('input', function(e){
            const precioMinimo = parseFloat(e.target.value);
            const precioMaximo = parseFloat(precioMax.value);
            const btnEnviar = document.getElementById('btn-submit-filterForm');
            const alerta = document.getElementById('alerta-precioMin-incorrecto'); 

            if( precioMinimo > precioMaximo || isNaN(precioMinimo) || isNaN(precioMaximo) ){
                // Mostrar la alerta y Deshabilitar el btn enviar
                alerta.classList.remove('hidden');
                btnEnviar.setAttribute("disabled", true);
                btnEnviar.classList.remove('hover:bg-azul');
                btnEnviar.classList.add('bg-gray-400', 'border-gray-800', 'text-neutral-500', 'hover:bg-gray-600');
            }else{
                // Habilitar botón y restaurar los estilos originales cuando la validación es correcta
                alerta.classList.add('hidden');
                btnEnviar.removeAttribute("disabled");
                btnEnviar.classList.remove('bg-gray-400', 'border-gray-800', 'text-neutral-500', 'hover:bg-gray-600');
                btnEnviar.classList.add('hover:bg-azul');
            }
        });

        precioMax.addEventListener('input', function(e){
            const precioMinimo = parseFloat(precioMin.value);
            const precioMaximo = parseFloat(e.target.value);
            const btnEnviar = document.getElementById('btn-submit-filterForm');
            const alerta = document.getElementById('alerta-precioMin-incorrecto');

            if( precioMinimo > precioMaximo || isNaN(precioMinimo) || isNaN(precioMaximo) ){
                alerta.classList.remove('hidden');
                btnEnviar.setAttribute("disabled", true);
                btnEnviar.classList.remove('hover:bg-azul');
                btnEnviar.classList.add('bg-gray-400', 'border-gray-800', 'text-neutral-500', 'hover:bg-gray-600');
            }else{
                // Habilitar botón y restaurar los estilos originales cuando la validación es correcta
                alerta.classList.add('hidden');
                btnEnviar.removeAttribute("disabled");
                btnEnviar.classList.remove('bg-gray-400', 'border-gray-800', 'text-neutral-500', 'hover:bg-gray-600');
                btnEnviar.classList.add('hover:bg-azul');
            }
        });
    }
</script>
@endpush