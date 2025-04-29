@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Preguntas Frecuentes</h1>

    <div id="faqAccordion" class="space-y-4">
        <!-- Primera Pregunta -->
        <div class="bg-white border border-gray-200 rounded-lg">
            <h2 id="heading1">
                <button 
                    class="w-full flex justify-between items-center p-4 text-left text-lg font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring focus:ring-indigo-300 rounded-lg transition"
                    type="button"
                    aria-expanded="false" 
                    aria-controls="collapse1"
                    onclick="toggleFAQ(1)"
                >
                    ¿Cómo puedo registrarme?
                    <svg id="icon1" class="w-5 h-5 ml-2 transition-transform transform rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </h2>

            <div id="collapse1" class="hidden p-4 bg-gray-50">
                <div class="mb-4 p-4 border-l-4 border-indigo-500 bg-indigo-50">
                    <p class="text-gray-600">Para registrarte, simplemente haz clic en el ícono con forma de persona en la parte superior derecha y sigue las instrucciones.</p>
                </div>
            </div>
        </div>

        <!-- Segunda Pregunta -->
        <div class="bg-white border border-gray-200 rounded-lg">
            <h2 id="heading2">
                <button 
                    class="w-full flex justify-between items-center p-4 text-left text-lg font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring focus:ring-indigo-300 rounded-lg transition"
                    type="button"
                    aria-expanded="false" 
                    aria-controls="collapse2"
                    onclick="toggleFAQ(2)"
                >
                    ¿Cómo puedo cambiar mi contraseña?
                    <svg id="icon2" class="w-5 h-5 ml-2 transition-transform transform rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </h2>

            <div id="collapse2" class="hidden p-4 bg-gray-50">
                <div class="mb-4 p-4 border-l-4 border-indigo-500 bg-indigo-50">
                    <p class="text-gray-600">Para cambiar tu contraseña, ve a tu perfil, selecciona "Contraseña" y sigue los pasos indicados.</p>
                </div>
            </div>
        </div>

        <!-- Tercera Pregunta -->
        <div class="bg-white border border-gray-200 rounded-lg">
            <h2 id="heading3">
                <button 
                    class="w-full flex justify-between items-center p-4 text-left text-lg font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring focus:ring-indigo-300 rounded-lg transition"
                    type="button"
                    aria-expanded="false" 
                    aria-controls="collapse3"
                    onclick="toggleFAQ(3)"
                >
                    ¿Cómo puedo contactar con el soporte técnico?
                    <svg id="icon3" class="w-5 h-5 ml-2 transition-transform transform rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </h2>

            <div id="collapse3" class="hidden p-4 bg-gray-50">
                <div class="mb-4 p-4 border-l-4 border-indigo-500 bg-indigo-50">
                    <p class="text-gray-600">Puedes contactar con el soporte técnico enviando un correo electrónico a contact@pccraft.com</p>
                </div>
            </div>
        </div>

        <!-- Cuarta Pregunta -->
        <div class="bg-white border border-gray-200 rounded-lg">
            <h2 id="heading3">
                <button 
                    class="w-full flex justify-between items-center p-4 text-left text-lg font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring focus:ring-indigo-300 rounded-lg transition"
                    type="button"
                    aria-expanded="false" 
                    aria-controls="collapse4"
                    onclick="toggleFAQ(4)"
                >
                    ¿Qué puedo comprar?
                    <svg id="icon3" class="w-5 h-5 ml-2 transition-transform transform rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </h2>

            <div id="collapse4" class="hidden p-4 bg-gray-50">
                <div class="mb-4 p-4 border-l-4 border-indigo-500 bg-indigo-50">
                    <p class="text-gray-600">Puedes comprar componentes individuales como tarjetas de video, tarjetas madre, memorias RAM, procesadores, Gabinetes, Discos Duro y Enfriamiento. Puedes comprarlos de forma individual o en conjunto armado como propia PC.</p>
                </div>
            </div>
        </div>

        <!-- Quinta Pregunta -->
        <div class="bg-white border border-gray-200 rounded-lg">
            <h2 id="heading3">
                <button 
                    class="w-full flex justify-between items-center p-4 text-left text-lg font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring focus:ring-indigo-300 rounded-lg transition"
                    type="button"
                    aria-expanded="false" 
                    aria-controls="collapse5"
                    onclick="toggleFAQ(5)"
                >
                    ¿Es seguro comprar en PC-Craft?
                    <svg id="icon3" class="w-5 h-5 ml-2 transition-transform transform rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </h2>

            <div id="collapse5" class="hidden p-4 bg-gray-50">
                <div class="mb-4 p-4 border-l-4 border-indigo-500 bg-indigo-50">
                    <p class="text-gray-600">¡Así es! Contamos con estándares de encriptación en las operaciones de compra
                        de equipo de cómputo para que lo que pidas te llegue sin contratiempos. Adicionalmente, protegemos toda la información personal asegurando que ni un 
                        tercero pueda acceder a ella. Nos alineamos con la Ley Federal de Protección de Datos.
                    </p>
                </div>
            </div>
        </div>

        <!-- Sexta Pregunta -->
        <div class="bg-white border border-gray-200 rounded-lg">
            <h2 id="heading3">
                <button 
                    class="w-full flex justify-between items-center p-4 text-left text-lg font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring focus:ring-indigo-300 rounded-lg transition"
                    type="button"
                    aria-expanded="false" 
                    aria-controls="collapse6"
                    onclick="toggleFAQ(6)"
                >
                    ¿Dónde puedo ver el precio y existencia?
                    <svg id="icon3" class="w-5 h-5 ml-2 transition-transform transform rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </h2>

            <div id="collapse6" class="hidden p-4 bg-gray-50">
                <div class="mb-4 p-4 border-l-4 border-indigo-500 bg-indigo-50">
                    <p class="text-gray-600">Para conocer la información referente al precio y 
                        disponibilidad, te invitamos a explorar directamente la página del artículo que desees. 
                        Todos los precios ya incluyen el IVA.
                    </p>
                </div>
            </div>
        </div>

        <!-- Séptima Pregunta -->
        <div class="bg-white border border-gray-200 rounded-lg">
            <h2 id="heading3">
                <button 
                    class="w-full flex justify-between items-center p-4 text-left text-lg font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring focus:ring-indigo-300 rounded-lg transition"
                    type="button"
                    aria-expanded="false" 
                    aria-controls="collapse7"
                    onclick="toggleFAQ(7)"
                >
                    ¿No vivo en México, pero me interesa comprar en PC-Craft Store?
                    <svg id="icon3" class="w-5 h-5 ml-2 transition-transform transform rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </h2>

            <div id="collapse7" class="hidden p-4 bg-gray-50">
                <div class="mb-4 p-4 border-l-4 border-indigo-500 bg-indigo-50">
                    <p class="text-gray-600">
                        Agradecemos el interés, pero por razones reglamentarias, 
                        no podemos efectuar envíos de productos fuera de la República 
                        Mexicana en este momento.
                    </p>
                </div>
            </div>
        </div>

        <!-- Octava Pregunta -->
        <div class="bg-white border border-gray-200 rounded-lg">
            <h2 id="heading3">
                <button 
                    class="w-full flex justify-between items-center p-4 text-left text-lg font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring focus:ring-indigo-300 rounded-lg transition"
                    type="button"
                    aria-expanded="false" 
                    aria-controls="collapse8"
                    onclick="toggleFAQ(8)"
                >
                    ¿No quiero el producto, me lo reembolsan?
                    <svg id="icon3" class="w-5 h-5 ml-2 transition-transform transform rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </h2>

            <div id="collapse8" class="hidden p-4 bg-gray-50">
                <div class="mb-4 p-4 border-l-4 border-indigo-500 bg-indigo-50">
                    <p class="text-gray-600">
                        Sentimos el problema, pero por cuestiones reglamentarias, 
                        no podemos ofrecer un reembolso del producto adquirido, 
                        cabe recalcar que una vez que ha sido comprado, 
                        no hay devoluciones ni cambios. Le recomendamos escoger
                        con cautela.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleFAQ(id) {
        const content = document.getElementById(`collapse${id}`);
        const icon = document.getElementById(`icon${id}`);
        content.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }
</script>
@endsection



