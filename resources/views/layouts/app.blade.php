<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @stack('styles') {{-- Reserva espacio para agregar hojas de estilo que sean diferentes, que no se requieran en todas las vistas --}}
        <title>PCCraft - @yield('title')</title>

        {{-- Fuentes --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

        @vite('resources/css/app.css')
        @vite('resources/js/app.js') {{-- Para Flowbite --}}

        {{-- !Carrusel productos recomendados --}}
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

        {{-- Pluggin accesibilidad --}}
        <script src="https://website-widgets.pages.dev/dist/sienna.min.js" defer></script>

        <style>
        .relative {
            position: relative;
        }

        span.absolute {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: #3B82F6;
            color: white;
            border-radius: 50%;
            padding: 4px 6px;
            font-size: 12px;
            font-weight: bold;
            line-height: 1;
        }
    </style>
    </head>

    <body class="bg-white">

    <header class="p-3 md:p-5 border-b bg-white shadow relative z-50">
    <div class="max-w-screen-lg container mx-auto flex justify-between items-center font-['roboto'] font-medium text-sm">
        <!-- Logo - visible en todos los tamaños -->
        <a href="{{ route('home') }}" class="z-10">
            <img class="w-12 md:w-16" src="{{ asset('img/logo.png') }}" alt="Imagen Logo">
        </a>

        <!-- Botón menú hamburguesa - solo visible en móvil -->
        <button id="mobile-menu-button" class="md:hidden z-10 text-gray-700">
            <i class="fa-solid fa-bars fa-lg"></i>
        </button>

        <!-- Overlay para menú móvil -->
        <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden"></div>

        <!-- Menú móvil - oculto por defecto -->
        <div id="mobile-menu" class="fixed top-0 right-0 h-full w-64 bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out z-30">
            <div class="p-5">
                <button id="close-mobile-menu" class="absolute top-4 right-4 text-gray-700">
                    <i class="fa-solid fa-times fa-lg"></i>
                </button>
                
                <div class="mt-8 space-y-4">
                    <!-- Barra de búsqueda móvil -->
                    <form action="{{route('productos.buscador')}}" method="get" class="mb-6">
                        <div class="flex">
                            <input type="text" 
                                name="search" 
                                placeholder="¿Qué producto estás buscando?"
                                class="w-full h-10 rounded-l-lg text-sm text-slate-600 placeholder:text-slate-400 placeholder:text-sm"
                                value="{{ $productToSearch ?? '' }}"
                                required
                            >
                            <button type="submit" class="bg-azul rounded-r-lg shadow-lg">
                                <i class="fa-solid fa-magnifying-glass p-2 text-white"></i>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Enlaces de navegación móvil -->
                    <nav class="flex flex-col space-y-4">
                        <a href="{{ route('productos.buscador') }}" class="block py-2">Productos</a>
                        <a href="{{ route('configuradorpc.index') }}" class="block py-2">Configurar PC</a>
                        <a href="{{ route('faqs.index') }}" class="block py-2">Soporte</a>
                    </nav>
                    
                    <hr class="my-4">
                    
                    <!-- Opciones de usuario móvil -->
                    @guest
                        <a href="{{ route('login') }}" class="block py-2">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="block py-2">Registrarse</a>
                    @endguest
                    
                    @auth
                        <a href="{{ route('profile.edit') }}" class="block py-2">Perfil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block py-2">Salir</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Contenido navegación desktop -->
        <div class="hidden md:flex items-center justify-between w-full ml-6">
            <!-- Navbar links - solo visible en desktop -->
            <nav class="flex justify-between gap-8 lg:gap-16">
                <a href="{{ route('productos.buscador') }}">Productos</a>
                <a href="{{ route('configuradorpc.index') }}">Configurar PC</a>
                <a href="{{ route('faqs.index') }}">Soporte</a>
            </nav>

            <div class="flex items-center gap-4">
                <!-- Barra de Búsqueda - solo visible en desktop -->
                <form action="{{route('productos.buscador')}}" method="get" class="hidden lg:block">
                    <input type="text" 
                        name="search" 
                        id="search-bar"
                        placeholder="¿Qué producto estás buscando?"
                        class="w-52 lg:w-80 h-10 rounded-lg text-sm text-slate-600 placeholder:text-slate-400 placeholder:text-sm"
                        value="{{ $productToSearch ?? '' }}"
                        required
                    >
                    <button type="submit" class="ml-1 bg-azul rounded-xl shadow-lg">
                        <i class="fa-solid fa-magnifying-glass p-2 text-white"></i>
                    </button>
                </form>

                <!-- Iconos de usuario y carrito - visibles en desktop -->
                <div class="flex items-center gap-4">
                    <!-- Menú de usuario -->
                    <div class="relative">
                        @guest
                        <button id="user-menu-button" class="flex items-center text-gray-700 hover:text-gray-900 focus:outline-none">
                            <i class="fa-lg fa-regular fa-user cursor-pointer"></i>
                        </button>
                        <div id="user-menu" class="hidden absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                            <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Iniciar Sesión</a>
                            <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Registrarse</a>
                        </div>
                        @endguest

                        @auth
                        <button id="auth-menu-button" class="flex items-center text-gray-700 hover:text-gray-900 focus:outline-none">
                            <i class="fa-lg fa-regular fa-user cursor-pointer"></i>
                        </button>
                        
                        <div id="auth-menu" class="hidden absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Salir</button>
                            </form>
                        </div>
                        @endauth
                    </div>

                    <!-- Carrito de compras -->
                    @auth
                        <div class="relative">
                            <a href="{{ route('cart.index') }}"> 
                                <i class="fa-solid fa-cart-shopping fa-lg cursor-pointer"></i>

                                @if(Cart::session(auth()->id())->getTotalQuantity() > 0)
                                    <span class="absolute -top-1 -right-1 inline-block w-4 h-4 text-xs font-bold text-white bg-blue-500 rounded-full">
                                        {{ Cart::session(auth()->id())->getTotalQuantity() }}
                                    </span>
                                @endif
                            </a>
                        </div>
                    @endauth

                    @guest
                        <div class="relative">
                            <a href="{{ route('login') }}"> 
                                <i class="fa-solid fa-cart-shopping fa-lg cursor-pointer"></i>
                            </a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>

        <!-- Iconos de usuario y carrito para móvil - visibles junto al logo -->
        <div class="flex md:hidden items-center gap-3 z-10">
            @auth
                <div class="relative">
                    <a href="{{ route('cart.index') }}"> 
                        <i class="fa-solid fa-cart-shopping fa-lg cursor-pointer"></i>
                        @if(Cart::session(auth()->id())->getTotalQuantity() > 0)
                            <span class="absolute -top-1 -right-1 inline-block w-4 h-4 text-xs font-bold text-white bg-blue-500 rounded-full">
                                {{ Cart::session(auth()->id())->getTotalQuantity() }}
                            </span>
                        @endif
                    </a>
                </div>
            @endauth

            @guest
                <div class="relative">
                    <a href="{{ route('login') }}"> 
                        <i class="fa-solid fa-cart-shopping fa-lg cursor-pointer"></i>
                    </a>
                </div>
            @endguest
        </div>
    </div>
</header>

        <main class="mx-auto font-['poppins']">
            @yield('content')
        </main>

        <footer class="bg-negro text-center p-5 md:p-7 pb-8 md:pb-10 text-xs text-white font-['poppins']">
            <!-- Logo -->
            <div class="flex justify-center">
                <img src="{{ asset('img/logo-sf.png') }}" 
                    alt="Imagen Logo"
                    class="w-20 md:w-24 mt-2 mb-6 md:mb-9"
                >
            </div>
            
            <!-- Columnas de información - Responsive -->
            <div class="flex flex-col md:flex-row justify-center text-left gap-8 md:gap-10 mb-6 md:mb-0">
                <!-- Links - Primera columna -->
                <ul class="list-disc w-full md:w-40 flex flex-col items-center md:items-start">
                    <li class="mb-2"> <a href="{{ route('configuradorpc.index') }}">Configurar PC</a> </li> 
                    <li class="mb-2"> <a href="{{ route('productos.buscador') }}">Productos</a> </li>
                    <li class="mb-2"> <a href="#">Nosotros</a> </li>
                    <li class="mb-2"> <a href="{{ route('faqs.index') }}">Soporte</a> </li>
                </ul>
                
                <!-- Contacto - Segunda columna -->
                <ul class="w-full md:w-40 text-center mb-4 md:mb-0">
                    <li class="mb-2"> <i class="fa-solid fa-phone"></i> 999 999 999 </li>
                    <li class="mb-2"> <i class="fa-regular fa-envelope"></i> contact@pccraft.com </li>
                </ul>
                
                <!-- Dirección - Tercera columna -->
                <div class="w-full md:w-40 text-center md:text-left">
                    <p class="md:ml-2 mb-0.5"><i class="fa-solid fa-location-dot"></i> Calle 38F</p>
                    <p class="md:ml-5 mb-0.5">Fracc. Las Américas</p>
                    <p class="md:ml-5 mb-0.5">CP 97301</p>
                    <p class="md:ml-5 mb-0.5">Mérida, Yucatán</p>
                </div>
            </div>
            
            <!-- Redes sociales -->
            <div class="flex flex-row justify-center gap-4 mt-6 md:mt-1 mb-6">
                <a href="#"> <i class="fa-brands fa-whatsapp fa-2x"></i> </a>
                <a href="#"> <i class="fa-brands fa-facebook fa-2x"></i> </a>
                <a href="#"> <i class="fa-brands fa-square-x-twitter fa-2x"></i> </a>
            </div>

            <!-- Copyright -->
            <div class="mt-4 md:mt-7">
                <p>PCCraft - Todos los derechos reservados {{ now()->year }}</p>
            </div>
        </footer>

        <script src="https://kit.fontawesome.com/5a52c5581a.js" crossorigin="anonymous"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Desplegar menú para usuarios no autenticados
                const userMenuButton = document.getElementById('user-menu-button');
                const userMenu = document.getElementById('user-menu');

                if (userMenuButton) {
                    userMenuButton.addEventListener('click', function () {
                        userMenu.classList.toggle('hidden');
                    });
                }

                // Desplegar menú para usuarios autenticados
                const authMenuButton = document.getElementById('auth-menu-button');
                const authMenu = document.getElementById('auth-menu');

                if (authMenuButton) {
                    authMenuButton.addEventListener('click', function () {
                        authMenu.classList.toggle('hidden');
                    });
                }
            });
        </script>
        
        @stack('scripts')
    </body>
</html>


<script>
    // Funcionalidad para menú móvil
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.remove('translate-x-full');
        document.getElementById('mobile-menu-overlay').classList.remove('hidden');
        document.body.classList.add('overflow-hidden'); // Prevenir scroll
    });

    document.getElementById('close-mobile-menu').addEventListener('click', closeMenu);
    document.getElementById('mobile-menu-overlay').addEventListener('click', closeMenu);

    function closeMenu() {
        document.getElementById('mobile-menu').classList.add('translate-x-full');
        document.getElementById('mobile-menu-overlay').classList.add('hidden');
        document.body.classList.remove('overflow-hidden'); // Permitir scroll nuevamente
    }

    // Funcionalidad para menús desplegables de usuario (desktop)
    document.addEventListener('DOMContentLoaded', function() {
        // Para usuarios no autenticados
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');
        
        if (userMenuButton && userMenu) {
            userMenuButton.addEventListener('click', function() {
                userMenu.classList.toggle('hidden');
            });
            
            // Cerrar menú al hacer clic fuera
            document.addEventListener('click', function(event) {
                if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                    userMenu.classList.add('hidden');
                }
            });
        }
        
        // Para usuarios autenticados
        const authMenuButton = document.getElementById('auth-menu-button');
        const authMenu = document.getElementById('auth-menu');
        
        if (authMenuButton && authMenu) {
            authMenuButton.addEventListener('click', function() {
                authMenu.classList.toggle('hidden');
            });
            
            // Cerrar menú al hacer clic fuera
            document.addEventListener('click', function(event) {
                if (!authMenuButton.contains(event.target) && !authMenu.contains(event.target)) {
                    authMenu.classList.add('hidden');
                }
            });
        }
    });
</script>
<!-- Script para el funcionamiento del menú desplegable -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Para usuarios no autenticados
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');
    
    if (userMenuButton && userMenu) {
        userMenuButton.addEventListener('click', function(event) {
            event.stopPropagation();
            userMenu.classList.toggle('hidden');
        });
        
        // Cerrar menú al hacer clic fuera
        document.addEventListener('click', function(event) {
            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    }
    
    // Para usuarios autenticados
    const authMenuButton = document.getElementById('auth-menu-button');
    const authMenu = document.getElementById('auth-menu');
    
    if (authMenuButton && authMenu) {
        authMenuButton.addEventListener('click', function(event) {
            event.stopPropagation();
            authMenu.classList.toggle('hidden');
        });
        
        // Cerrar menú al hacer clic fuera
        document.addEventListener('click', function(event) {
            if (!authMenuButton.contains(event.target) && !authMenu.contains(event.target)) {
                authMenu.classList.add('hidden');
            }
        });
    }
});
</script>