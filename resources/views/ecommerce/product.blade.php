@extends('layouts.app')

@section('title', $product->nombre)

@section('content')

    {{-- Menu Migajas de pan (Flowbite) ✅ --}}
    <div class="mt-4 flex flex-col items-center w-full">
        <nav class="w-10/12 mt-3.5 ml-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2 rtl:space-x-reverse text-sm">
                <li class="inline-flex items-center justify-center">
                    <a href="#" class="px-0.5 inline-flex items-center text-gray-500 hover:text-azul">
                        Productos
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-azul mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="#" class="ms-2 px-0.5 text-gray-500 hover:text-azul"> 
                            {{ $product->category->nombre_categoria }} 
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-azul mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ms-2 font-medium text-gray-700"> {{ $product->nombre }} </span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    {{--! Descripcion producto ❗ --}}
    <div class="mt-7 mb-10 flex flex-col items-center w-full">
        {{-- Imagen y Especificaciones Tecnicas--}}
        <div class="w-11/12 h-[33rem] mt-2 px-12 flex justify-center gap-3">
            {{-- Imagenes --}}
            <div class="w-8/12 flex gap-1">
                {{-- Contenedor 3 imagenes --}}
                <div class="w-1/6 flex flex-col gap-6 justify-center items-center" id="container_3_images">
                    @foreach (json_decode($product->url_photo, true) as $photo)
                        <img 
                            src="{{ asset('storage/' . $photo) }}" 
                            class="w-full h-full max-h-28 object-contain rounded-lg border border-gray-200 cursor-pointer"
                            alt="Imagen {{ $product->nombre }}"
                        >
                    @endforeach
                </div>
                {{-- Contenedor Imagen Principal --}}
                <div id="imageZoom" 
                    {{-- Sin Classes After --}}
                    class="w-5/6 mx-5 flex justify-center items-center rounded-lg relative after:rounded-xl hover:cursor-crosshair"
                >
                    <img 
                        src="{{ asset('storage/' . json_decode($product->url_photo, true)[0] ) }}"
                        id="imagen_principal" 
                        alt="Imagen Producto"
                        class="w-full h-full object-contain border rounded-xl"
                    >
                </div>
            </div>

            {{-- Especificaciones producto --}}
            <div class="w-4/12 mt-8">
                <h2 class="text-2xl font-medium">{{ $product->nombre }}</h2>
                <p class="mt-1.5 text-zinc-400">MODELO: {{ $product->modelo }}</p>
                <a href="#detalles-comentarios" class="mt-2 flex items-center">
                <span class="text-xs text-amber-500">
                {{-- MODIFICADO --}}
                @if ($product->avgRaiting > 0)
                    @php
                        $count = round($product->avgRaiting); // Redondea la calificación promedio para mostrar estrellas completas
                    @endphp

                    <div class="flex items-center">
                        <!-- Estrellas llenas -->
                        @for ($i = 0; $i < $count; $i++)
                            <i class="fa-solid fa-star text-azul"></i>
                        @endfor
                        <!-- Estrellas vacías hasta completar 5 -->
                        @for ($i = $count; $i < 5; $i++)
                            <i class="fa-regular fa-star text-azul"></i>
                        @endfor

                        <span class="ml-2 text-sm text-black font-medium">{{ number_format($product->avgRaiting, 1) }}</span>
                        <p class="ml-2 font-['roboto'] font-bold text-xs text-zinc-500 hover:text-azul">
                            {{ $product->comentarios->count() }} calificaciones
                        </p>
                    </div>
                @else
                    <span class="text-sm text-black font-medium">0 calificaciones</span>
                @endif
                </span>

                </a>
                <p class="mt-5 font-['roboto'] text-2xl font-medium">
                    <span>${{ $product->precio_final }} MXN</span>
                    @if ( $product->descuento > 0 )
                        <span class="ml-1.5 text-zinc-400 line-through">${{ $product->precio }}</span>
                        <span class="ml-2 font-['roboto'] font-normal text-base text-red-600 py-1.5 px-1.5 bg-red-200 rounded-xl">-{{ $product->descuento }}% </span>
                    @endif
                </p>
                <p class="mt-5 text-sm text-justify leading-relaxed">{{ $product->descripcion }}</p>
                <p class="mt-5 font-['roboto'] text-zinc-700 font-medium">Existencias: <span class="text-verde">{{ $product->stock }}</span></p>

                {{-- Agregar al Carrito --}}
                <div class="mt-4">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->ID_producto }}">
                        <input type="hidden" name="nombre" value="{{ $product->nombre }}">
                        <input type="hidden" name="modelo" value="{{ $product->modelo }}">
                        <input type="hidden" name="fabricante" value="{{ $product->fabricante }}">
                        <input type="hidden" name="descuento" value="{{ $product->descuento }}">
                        {{-- <input type="hidden" name="precio" value="{{ (float) str_replace(',', '', $product->precio_final) }}"> --}}
                        <input type="hidden" name="precio" value="{{ $product->precio }}">
                        <input type="hidden" name="cantidad" value="1">  {{-- Cambiar "quantity" por "cantidad" --}}
                        <input type="hidden" name="url_photo[]" value="{{ $product->url_photo }}"> {{-- Asegúrate de que esté correcto --}}
                        
                        {{-- Mostrar errores de validación --}}
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

                        {{-- Verificar si el stock es mayor a 0 para mostrar el botón --}}
                        @if($product->stock > 0)
                            <button type="submit" class="py-2 text-base px-3.5 bg-azul border border-azul rounded-lg text-white shadow hover:shadow-xl">
                                <span class="mr-2"><i class="fa-solid fa-cart-shopping"></i></span>
                                Agregar al carrito
                            </button>
                        @else
                            <p class="text-red-500 mt-4">Producto agotado</p>
                        @endif
                    </form>
                </div>
            </div>
        </div>


        {{-- Tab Detalles-Comentarios (Usando Flowbite) --}}
        <div class="w-full mt-10 flex flex-col justify-center items-center" id="detalles-comentarios">
            {{-- Wrapper --}}
            <div class="w-10/12 flex flex-col">

                {{-- Titulos Tabs --}}
                <div class="w-full mb-2 border-b border-gray-200">
                    <ul class="flex justify-center" id="tab-detalles-comentarios" data-tabs-toggle="#tab-detalles-comentarios-content" role="tablist">
                        <li class="w-1/2" role="presentation">
                            <button class="w-full p-4 border-b-2 border-azul text-xl font-medium font-['poppins']" id="detalles-tab" data-tabs-target="#detalles" role="tab" aria-controls="detalles" aria-selected="false">Detalles del Producto</button>
                        </li>
                        <li class="w-1/2" role="presentation">
                            <button class="w-full p-4 border-b-2 border-azul text-xl font-medium font-['poppins']" id="comentarios-tab" data-tabs-target="#comentarios" role="tab" aria-controls="comentarios" aria-selected="false">Comentarios del Producto</button>
                        </li>
                    </ul>
                </div>

                {{-- Contenido Tabs --}}
                <div class="font-['roboto']" id="tab-detalles-comentarios-content">
                    {{-- Tab Detalles del Producto --}}
                    <div class="flex justify-center flex-col items-center font-['poppins']" id="detalles" role="tabpanel" aria-labelledby="detalles-tab">
                        <div class="w-9/12 mt-10 flex justify-center">
                            {{-- Tabla Specs JSON --}}
                            <table class="w-full table-auto text-sm text-left rtl:text-right text-gray-500">
                                <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="w-1/2 px-6 py-3">Característica</th>
                                        <th scope="col" class="w-1/2 px-6 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product->especificaciones as $spec => $value)
                                        {{-- <p class="ml-5"> <span class="font-medium">{{ Str::headline($spec) }}</span>: {{$value}} </p> --}}
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"> {{ Str::headline($spec) }} </td>
                                            <td class="px-6 py-4"> {{ $value }} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Tab Comentarios --}}
                    <div class="flex flex-col justify-center items-center" id="comentarios" role="tabpanel" aria-labelledby="comentarios-tab">
                        <div class="w-10/12">
                            {{-- Filtros Comentarios --}} {{-- MODIFICADO --}}
                            <div class="mt-5 mx-1 px-6 flex justify-between items-center text-lg">
                                <h4>Todos los comentarios <span class="text-sm text-zinc-400">({{ $product->comentarios->count() }})</span></h4>
                                {{-- Formulario de filtro, no me funcionó saludos--}}

                            </div>         
                            {{-- Agregar nuevo comentario --}}
                            <div class="mt-5 mx-7">
                                @guest
                                    <a href="/login" class="hover:text-azul m-2">
                                        Por favor, inicia sesión para escribir un comentario
                                    </a>
                                @endguest

                                @auth
                                    {{-- Si el usuario no ha comprado el producto --}}
                                    @if (!$product->comprado)
                                        <p class="my-10 text-red-700">¡Para comentar sobre este producto, debe comprarlo!</p>
                                    @endif

                                    {{-- Si el usuario ha comentado en todas sus compras del producto --}}
                                    @if ($product->resenado)
                                        <p class="my-10 text-red-700">¡Ya ha comentado sobre todas sus compras de este producto!</p>
                                    @endif

                                    {{-- Si el usuario ha comprado y tiene una compra sin reseña --}}
                                    @if ($product->comprado && !$product->resenado && $product->ultimaOrdenEntregada)
                                        <a href="{{ route('comment.index', ['orderId' => $product->ultimaOrdenEntregada->ID_Orden, 'productId' => $product->ID_producto]) }}" 
                                        class="py-2 text-base px-3.5 bg-azul border border-azul rounded-lg text-white shadow hover:shadow-xl">
                                            Agregar un nuevo comentario
                                        </a>
                                    @endif
                                @endauth
                            </div>

                
                            {{-- Container Comentarios --}}
                            <div id="comentarios-container" class="mt-6 mb-5 px-7 flex flex-col gap-4">

                                {{-- Si aun no hay comentarios --}}
                                @if ( count($product->comentarios) == 0 )
                                    <div class="p-5 border border-gray-200 rounded-lg shadow">
                                        <p class=" text-lg">Aún no hay comentarios para este producto</p>
                                    </div>
                                @endif

                                {{-- Mostrar los comentarios --}}
                                @foreach ($product->comentarios as $comentario)
                                    <div class="p-5 border border-gray-200 rounded-lg shadow comentario
                                    {{ $loop->index >= 2 ? 'hidden' : '' }}">
                                        {{-- Estrellas --}}
                                        <p class="text-azul">
                                            {{-- Dependiendo de la calificacion, mostrar el num de estrellas --}}
                                            @for ($i = 0; $i < $comentario->calificacion; $i++)
                                                <i class="fa-solid fa-star"></i>
                                            @endfor
                                        </p>
                                        {{-- Nombre Usuario --}}
                                        <p class="mt-2 font-medium">{{ $comentario->productoOrdens->orden->usuario->name . $comentario->productoOrdens->orden->usuario->last_name}}</p>
                                        {{-- Titulo comentario --}}
                                        <p class="mt-2 text-zinc-700"> {{ $comentario->titulo }} </p>
                                        {{-- Comentario --}}
                                        <p class="mt-1.5 px-3">
                                            {{ $comentario->comentario }}
                                        </p>
                                        {{-- Fecha creacion --}}
                                        <p class="mt-2.5 text-sm text-zinc-400">Publicado el {{ $comentario->fecha }}</p>
                                    </div>
                                @endforeach
                                {{-- !Probando las ordenes --}}
                                {{-- @foreach ($product->ordenes as $orden)
                                    <div>
                                        <p>Orden</p>
                                    </div>
                                @endforeach --}}
                                {{-- Comentario 1 --}}
                                {{-- <div class="p-5 border border-gray-200 rounded-lg shadow">
                                    <p class="text-azul">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </p>
                                    <p class="mt-2 font-medium">Nombre Usuario</p>
                                    <p class="mt-2 text-zinc-700">Titulo comentario</p>
                                    <p class="mt-1.5 px-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui in delectus consectetur consequuntur pariatur ipsa fugiat eligendi reiciendis illo, quod consequatur velit perferendis? Quo nisi omnis ullam aliquid quasi impedit?
                                    Nihil fugit eligendi repudiandae nam natus porro earum rem dignissimos, accusantium mollitia, doloribus amet exercitationem, ipsam cum reprehenderit.</p>
                                    <p class="mt-2.5 text-sm text-zinc-400">Publicado el 20/10/22</p>
                                </div> --}}

                            {{-- Paginacion --}}
                            @if ( count($product->comentarios) > 2 )
                                <div class="text-center mt-4">
                                <button id="ver-mas-btn" class="py-2 px-4 bg-azul border border-azul rounded-lg text-white shadow hover:shadow-xl" style="z-index: 10;">Ver más opiniones</button>
                                </div>  
                            @endif 
                            
                        </div>

                    </div>
                </div>

            </div>
        </div>


        {{-- Detalles JSON --}}
        {{-- <div class="w-9/12 mt-16 flex flex-col justify-center items-center font-['roboto']">
            <div class="w-full text-center">
                <h3 class="pb-1 text-2xl font-medium font-['poppins']">Detalles del Producto</h3>
                <div class="w-full h-0.5 bg-azul mx-auto mt-2"></div>
            </div>
            <div class="w-full mt-7 px-7">
                <div class="p-4 py-7 border border-slate-200 rounded-lg shadow leading-7">
                    @foreach ($product->especificaciones as $spec => $value)
                    <p class="ml-5"> <span class="font-medium">{{ Str::headline($spec) }}</span>: {{$value}} </p>
                    @endforeach
                </div>
            </div>
        </div> --}}

        {{-- Productos Recomendados --}}
        <section class="w-full mt-20 mb-6">
            <x-ecommerce.productos-recomendados :productosRecomendados="$productosRecomendados" />
        </section>

        
@endsection

<style>
    #ver-mas-btn {
    z-index: 9999; /* Mayor valor para asegurarte de que esté al frente */
    position: relative; /* Asegura que el z-index tenga efecto */
    display: block; /* Asegúrate de que esté visible */
}
.comentario {
    transition: all 0.3s ease;
}

    :root {
        /* --image: url('https://www.punchtechnology.co.uk/wp-content/uploads/2024/02/vida2-1.jpg'); */
        --image: url("{{asset('storage/' . json_decode($product->url_photo, true)[0] )}}" );
        --zoom-x: 50%;
        --zoom-y: 50%;
        --display: none;
    }

    #imageZoom::after {
        display: var(--display);
        content: '';
        width: 100%;
        height: 100%;
        background-image: var(--image);
        background-size: 200%;
        background-position: var(--zoom-x) var(--zoom-y);
        position: absolute;
        left: 0;
        top: 0;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', (e) => {
        interactuarImagenes();
        zoomImages();
    });
    
    // Funcion que inserta la imagen en el div mas grande cuando se hace click en alguna de las 3 imagenes del producto
    function interactuarImagenes(){
        let contenedorImagenes = document.querySelector("#container_3_images");
        let imagenesContenedor = contenedorImagenes.querySelectorAll('img');
        let contenedorImagenPrincipal = document.querySelector('#imageZoom');
        let imagenPrincipal = contenedorImagenPrincipal.querySelector('img');

        // Iterar sobre las 3 imagenes y agregarles el comportamiento
        imagenesContenedor.forEach((img) => {
            img.addEventListener('click', () => {
                imagenPrincipal.src = img.src;
                // Actualizar '--image' para que funcione 'zoomImages'
                contenedorImagenPrincipal.style.setProperty('--image', 'url(' + img.src + ')' );
            });
        });
    }

    // Función para manejar el zoom en las imágenes
    function zoomImages() {
        let contenedorImagen = document.querySelector("#imageZoom");

        contenedorImagen.addEventListener('mousemove', (e) => {
            // Mostrar el pseudo-elemento ::after
            contenedorImagen.style.setProperty('--display', 'block');
            let pointer = {
                x: (e.offsetX * 100) / contenedorImagen.offsetWidth,
                y: (e.offsetY * 100) / contenedorImagen.offsetHeight
            };

            // Actualizar las variables CSS para el zoom
            contenedorImagen.style.setProperty('--zoom-x', pointer.x + '%');
            contenedorImagen.style.setProperty('--zoom-y', pointer.y + '%');
        });

        // Ocultar el pseudo-elemento cuando no está en movimiento
        contenedorImagen.addEventListener('mouseleave', () => {
            contenedorImagen.style.setProperty('--display', 'none');
        });
    }

</script>

<script>
    document.getElementById('filtro').addEventListener('change', function() {
        let form = document.getElementById('filtro-form');
        let url = form.action;
        let formData = new FormData(form);

        fetch(url + '?' + new URLSearchParams(formData), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Reemplaza el contenido del contenedor de comentarios
            document.getElementById('comentarios-container').innerHTML = html;
        })
        .catch(error => console.warn(error));
    });
</script>

{{-- Script para mostrar más comentarios --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const verMasBtn = document.getElementById('ver-mas-btn');
        if (verMasBtn) {
            verMasBtn.addEventListener('click', function() {
                // Muestra todos los comentarios ocultos
                document.querySelectorAll('.comentario.hidden').forEach(comentario => {
                    comentario.classList.remove('hidden');
                });
                // Oculta el botón una vez que se muestran los comentarios
                this.style.display = 'none';
            });
        }
    });
</script>
