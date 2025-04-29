@extends('layouts.app')

@section('title', 'Configurador PC')

@section('content')

<div class="container mx-auto mt-6 mb-6 w-full lg:w-2/3">

    <!-- Título del carrito -->
  <nav aria-label="breadcrumb" class="mb-8">
      <ol class="breadcrumb flex space-x-2">
          <li class="breadcrumb-item"><a href="/" class="text-2xl font-medium text-blue-600 dark:text-white">Tienda / </a></li>
          <li class="breadcrumb-item active text-2xl font-medium text-gray-900 dark:text-white" aria-current="page">Configurador PC</li>
      </ol>
  </nav>

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

    <div class="grid grid-cols-3 gap-4">
      <div class="col-span-2">
      <div id="accordion-color" data-accordion="collapse" data-active-classes="bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-white">
          
          <!-- 1-PROCESADOR -->
          <h2 id="accordion-color-heading-1">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-blue-600 border border-gray-200 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-color-body-1" aria-expanded="{{ $categoriaFaltante == 'Procesador' ? 'true' : 'false' }}" aria-controls="accordion-color-body-1">
              <span></span>
              <span class="text-blue-600 font-medium text-1xl">Procesador</span>
              <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
              </svg>
            </button>
          </h2>
          <div id="accordion-color-body-1" class="hidden" aria-labelledby="accordion-color-heading-1">
            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">

              <section class="mt-4 mb-4 flex flex-col justify-center items-center w-full">
                  <div>
                      <h3 class="font-medium text-1xl text-center">Selecciona un procesador:</h3>
                  </div>
                  {{-- Tarjetas de productos --}}
                  <div class="grid grid-cols-3 w-full text-center mt-4 mx-4">

                    @if(session()->has('componentesQuery.procesadores'))
                      @php
                          $procesadores = session('componentesQuery.procesadores');
                      @endphp
                      @foreach($procesadores as $procesador)
                      @if(($procesador->stock)>0)
                      <div class="border-2 mx-3 my-5 border-gray-200 rounded-lg pt-2 pb-5 px-3 font-medium shadow-xl">
                          {{-- Imagen --}}
                          <div class="px-2 flex justify-center">
                              <img class="flex items-center max-h-40" src="{{ asset('storage/' . json_decode($procesador->url_photo, true)[0] ) }}" alt="{{$procesador->name}}">
                          </div>
                          {{-- Info Producto --}}
                          <div>
                              <p class="mt-2 mb-2 leading-relaxed">{{$procesador->nombre}}</p>
                              <p class="mt-2 mb-2 text-verde">{{$procesador->category->nombre_categoria}}</p>
                              <p class="mt-2 mb-2 font-['roboto'] font-normal">
                                ${{ (100 - $procesador->descuento) * 0.01 * $procesador->precio }} MXN  {{-- !Calcularlo en el Controlador --}}
                                @if ( $procesador->descuento > 0 )
                                    <span class="font-normal shadow-xl text-zinc-400 line-through">${{ $procesador->precio }}</span>
                                    <span class="font-['roboto'] font-normal text-base text-red-600 py-1.5 px-1.5 bg-red-200 rounded-xl">-{{ $procesador->descuento }}% </span>
                                @endif
                              </p>
                          </div>
                          <form action="{{route('configuradorpc.add')}}" method="POST">
                            @csrf
                            <input type="hidden" id="id" name="id" value="{{ $procesador->ID_producto }}">
                            <input type="hidden" id="categoria" name="categoria" value="{{ $procesador->category->nombre_categoria }}">
                            <button class="py-2 px-4 mt-2 mb-2 bg-azul border border-azul rounded-lg text-white shadow hover:shadow-xl">Seleccionar</button>
                          </form>
                      </div>
                      @endif
                      @endforeach
                    @endif
                  </div>
              </section>

          </div>


          </div>

          <!-- 2-TARJETA MADRE -->
          <h2 id="accordion-color-heading-2">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-color-body-2" aria-expanded="{{ $categoriaFaltante == 'Tarjeta Madre' ? 'true' : 'false' }}" aria-controls="accordion-color-body-2">
              <span></span>
              <span class="text-blue-600">Tarjeta Madre</span>
              <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
              </svg>
            </button>
          </h2>
          <div id="accordion-color-body-2" class="hidden" aria-labelledby="accordion-color-heading-2">
            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
              <section class="mt-4 mb-4 flex flex-col justify-center items-center w-full">
                <div>
                    <h3 class="font-medium text-1xl text-center">Selecciona una tarjeta madre:</h3>
                </div>
                {{-- Tarjetas de productos --}}
                <div class="grid grid-cols-3 w-full text-center mt-4 mx-4">    
                  @if(session()->has('componentesQuery.tarjetaMadres'))
                  @php
                      $tarjetaMadres = session('componentesQuery.tarjetaMadres');
                  @endphp
                        @foreach($tarjetaMadres as $tarjetaMadre)
                        @if(($tarjetaMadre->stock)>0)
                        <div class="border-2 mx-3 my-5 border-gray-200 rounded-lg pt-2 pb-5 px-3 font-medium shadow-xl">
                            {{-- Imagen --}}
                            <div class="px-2 flex justify-center">
                                <img class="flex items-center max-h-40" src="{{ asset('storage/' . json_decode($tarjetaMadre->url_photo, true)[0] ) }}" alt="{{$tarjetaMadre->name}}">
                            </div>
                            {{-- Info Producto --}}
                            <div>
                                <p class="mt-2 mb-2 leading-relaxed">{{$tarjetaMadre->nombre}}</p>
                                <p class="mt-2 mb-2 text-verde">{{$tarjetaMadre->category->nombre_categoria}}</p>
                                <p class="mt-2 mb-2 font-['roboto'] font-normal">
                                  ${{ (100 - $tarjetaMadre->descuento) * 0.01 * $tarjetaMadre->precio }} MXN
                                  @if ( $tarjetaMadre->descuento > 0 )
                                      <span class="font-normal shadow-xl text-zinc-400 line-through">${{ $tarjetaMadre->precio }}</span>
                                      <span class="font-['roboto'] font-normal text-base text-red-600 py-1.5 px-1.5 bg-red-200 rounded-xl">-{{ $tarjetaMadre->descuento }}% </span>
                                  @endif
                                </p>
                            </div>
                            <form action="{{route('configuradorpc.add')}}" method="POST">
                              @csrf
                              <input type="hidden" name="id" value="{{ $tarjetaMadre->ID_producto }}">
                              <input type="hidden" name="categoria" value="{{ $tarjetaMadre->category->nombre_categoria }}">
                              <button class="py-2 px-4 mt-2 mb-2 bg-azul border border-azul rounded-lg text-white shadow hover:shadow-xl">Seleccionar</button>
                            </form>
                        </div>
                        @endif
                        @endforeach
                    @endif
                </div>
            </section>
            </div>
          </div>

          <!-- 3-MEMORIA RAM -->
          <h2 id="accordion-color-heading-3">
              <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-blue-600 border border-gray-200 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-color-body-3" aria-expanded="{{ $categoriaFaltante == 'Memoría RAM' ? 'true' : 'false' }}" aria-controls="accordion-color-body-3">
                <span></span>
                <span class="text-blue-600">Memoria RAM</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                </svg>
              </button>
          </h2>
          <div id="accordion-color-body-3" class="hidden" aria-labelledby="accordion-color-heading-3">
              <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                <section class="mt-4 mb-4 flex flex-col justify-center items-center w-full">
                  <div>
                      <h3 class="font-medium text-1xl text-center">Selecciona memoria RAM:</h3>
                  </div>
                  {{-- Tarjetas de productos --}}
                  <div class="grid grid-cols-3 w-full text-center mt-4 mx-4">    
                      @if(isset($componentesQuery['memoriasRAM']))
                          @foreach($componentesQuery['memoriasRAM'] as $memoria)
                          @if(($memoria->stock)>0)
                          <div class="border-2 mx-3 my-5 border-gray-200 rounded-lg pt-2 pb-5 px-3 font-medium shadow-xl">
                              {{-- Imagen --}}
                              <div class="px-2 flex justify-center">
                                  <img class="flex items-center max-h-40" src="{{ asset('storage/' . json_decode($memoria->url_photo, true)[0] ) }}" alt="{{$memoria->name}}">
                              </div>
                              {{-- Info Producto --}}
                              <div>
                                  <p class="mt-2 mb-2 leading-relaxed">{{$memoria->nombre}}</p>
                                  <p class="mt-2 mb-2 text-verde">{{$memoria->category->nombre_categoria}}</p>
                                  <p class="mt-2 mb-2 font-['roboto'] font-normal">
                                    ${{ (100 - $memoria->descuento) * 0.01 * $memoria->precio }} MXN
                                    @if ( $memoria->descuento > 0 )
                                        <span class="font-normal shadow-xl text-zinc-400 line-through">${{ $memoria->precio }}</span>
                                        <span class="font-['roboto'] font-normal text-base text-red-600 py-1.5 px-1.5 bg-red-200 rounded-xl">-{{ $memoria->descuento }}% </span>
                                    @endif
                                  </p>
                              </div>
                              <form action="{{route('configuradorpc.add')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $memoria->ID_producto }}">
                                <input type="hidden" name="categoria" value="{{ $memoria->category->nombre_categoria }}">
                                <button class="py-2 px-4 mt-2 mb-2 bg-azul border border-azul rounded-lg text-white shadow hover:shadow-xl">Seleccionar</button>
                              </form>
                          </div>
                          @endif
                          @endforeach
                      @endif
                  </div>
              </section>
              
              </div>
          </div>

          <!-- 4-GABINETE -->
          <h2 id="accordion-color-heading-4">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-color-body-4" aria-expanded="{{ $categoriaFaltante == 'Gabinete' ? 'true' : 'false' }}" aria-controls="accordion-color-body-4">
              <span></span>
              <span class="text-blue-600">Gabinete</span>
              <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
              </svg>
            </button>
          </h2>
          <div id="accordion-color-body-4" class="hidden" aria-labelledby="accordion-color-heading-4">
            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
              <section class="mt-4 mb-4 flex flex-col justify-center items-center w-full">
                <div>
                    <h3 class="font-medium text-1xl text-center">Seleccionar Gabinete:</h3>
                </div>
                {{-- Tarjetas de productos --}}
                <div class="grid grid-cols-3 w-full text-center mt-4 mx-4">    
                    @if(isset($componentesQuery['gabinetes']))
                        @foreach($componentesQuery['gabinetes'] as $gabinete)
                        @if(($gabinete->stock)>0)
                        <div class="border-2 mx-3 my-5 border-gray-200 rounded-lg pt-2 pb-5 px-3 font-medium shadow-xl">
                            {{-- Imagen --}}
                            <div class="px-2 flex justify-center">
                                <img class="flex items-center max-h-40" src="{{ asset('storage/' . json_decode($gabinete->url_photo, true)[0] ) }}" alt="{{$gabinete->name}}">
                            </div>
                            {{-- Info Producto --}}
                            <div>
                                <p class="mt-2 mb-2 leading-relaxed">{{$gabinete->nombre}}</p>
                                <p class="mt-2 mb-2 text-verde">{{$gabinete->category->nombre_categoria}}</p>
                                <p class="mt-2 mb-2 font-['roboto'] font-normal">
                                  ${{ (100 - $gabinete->descuento) * 0.01 * $gabinete->precio }} MXN
                                  @if ( $gabinete->descuento > 0 )
                                      <span class="font-normal shadow-xl text-zinc-400 line-through">${{ $gabinete->precio }}</span>
                                      <span class="font-['roboto'] font-normal text-base text-red-600 py-1.5 px-1.5 bg-red-200 rounded-xl">-{{ $gabinete->descuento }}% </span>
                                  @endif
                                </p>
                            </div>
                            <form action="{{route('configuradorpc.add')}}" method="POST">
                              @csrf
                              <input type="hidden" name="id" value="{{ $gabinete->ID_producto }}">
                              <input type="hidden" name="categoria" value="{{ $gabinete->category->nombre_categoria }}">
                              <button class="py-2 px-4 mt-2 mb-2 bg-azul border border-azul rounded-lg text-white shadow hover:shadow-xl">Seleccionar</button>
                            </form>
                         </div>
                        @endif
                        @endforeach
                  @endif
                </div>
            </section>
            </div>
          </div>

          <!-- 5-TARJETA DE VIDEO -->
          <h2 id="accordion-color-heading-5">
              <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-blue-600 border border-gray-200 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-color-body-5" aria-expanded="{{ $categoriaFaltante == 'Tarjeta de Video' ? 'true' : 'false' }}" aria-controls="accordion-color-body-5">
                <span></span>
                <span class="text-blue-600">Tarjeta de Video</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                </svg>
              </button>
          </h2>
          <div id="accordion-color-body-5" class="hidden" aria-labelledby="accordion-color-heading-5">
            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
              <section class="mt-4 mb-4 flex flex-col justify-center items-center w-full">
                <div>
                    <h3 class="font-medium text-1xl text-center">Seleccionar Tarjeta de Video:</h3>
                </div>
                {{-- Tarjetas de productos --}}
                <div class="grid grid-cols-3 w-full text-center mt-4 mx-4">    
                    @if(isset($componentesQuery['tarjetasDeVideo']))
                        @foreach($componentesQuery['tarjetasDeVideo'] as $tarjetasDeVideo)
                        @if(($tarjetasDeVideo->stock)>0)
                        <div class="border-2 mx-3 my-5 border-gray-200 rounded-lg pt-2 pb-5 px-3 font-medium shadow-xl">
                            {{-- Imagen --}}
                            <div class="px-2 flex justify-center">
                                <img class="flex items-center max-h-40" src="{{ asset('storage/' . json_decode($tarjetasDeVideo->url_photo, true)[0] ) }}" alt="{{$tarjetasDeVideo->name}}">
                            </div>
                            {{-- Info Producto --}}
                            <div>
                                <p class="mt-2 mb-2 leading-relaxed">{{$tarjetasDeVideo->nombre}}</p>
                                <p class="mt-2 mb-2 text-verde">{{$tarjetasDeVideo->category->nombre_categoria}}</p>
                                <p class="mt-2 mb-2 font-['roboto'] font-normal">
                                  ${{ (100 - $tarjetasDeVideo->descuento) * 0.01 * $tarjetasDeVideo->precio }} MXN
                                  @if ( $tarjetasDeVideo->descuento > 0 )
                                      <span class="font-normal shadow-xl text-zinc-400 line-through">${{ $tarjetasDeVideo->precio }}</span>
                                      <span class="font-['roboto'] font-normal text-base text-red-600 py-1.5 px-1.5 bg-red-200 rounded-xl">-{{ $tarjetasDeVideo->descuento }}% </span>
                                  @endif
                                </p>
                            </div>
                            <form action="{{route('configuradorpc.add')}}" method="POST">
                              @csrf
                              <input type="hidden" name="id" value="{{ $tarjetasDeVideo->ID_producto }}">
                              <input type="hidden" name="categoria" value="{{ $tarjetasDeVideo->category->nombre_categoria }}">
                              <button class="py-2 px-4 mt-2 mb-2 bg-azul border border-azul rounded-lg text-white shadow hover:shadow-xl">Seleccionar</button>
                            </form>
                         </div>
                         @endif
                      @endforeach
                  @endif
                </div>
            </section>
            </div>
          </div>

          <!-- 6-ALMACENAMIENTO PRINCIPAL -->
          <h2 id="accordion-color-heading-6">
              <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-blue-600 border border-gray-200 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-color-body-6" aria-expanded="{{ $categoriaFaltante == 'Disco Duro' ? 'true' : 'false' }}" aria-controls="accordion-color-body-6">
                <span></span>
                <span class="text-blue-600">Almacenamiento</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                </svg>
              </button>
          </h2>
          <div id="accordion-color-body-6" class="hidden" aria-labelledby="accordion-color-heading-6">
            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
              <section class="mt-4 mb-4 flex flex-col justify-center items-center w-full">
                <div>
                    <h3 class="font-medium text-1xl text-center">Seleccionar Almacenamiento:</h3>
                </div>
                {{-- Tarjetas de productos --}}
                <div class="grid grid-cols-3 w-full text-center mt-4 mx-4">    
                    @if(isset($componentesQuery['almacenamientoPrincipal']))
                        @foreach($componentesQuery['almacenamientoPrincipal'] as $almacenamientoPrincipal)
                        @if(($almacenamientoPrincipal->stock)>0)
                        <div class="border-2 mx-3 my-5 border-gray-200 rounded-lg pt-2 pb-5 px-3 font-medium shadow-xl">
                            {{-- Imagen --}}
                            <div class="px-2 flex justify-center">
                                <img class="flex items-center max-h-40" src="{{ asset('storage/' . json_decode($almacenamientoPrincipal->url_photo, true)[0] ) }}" alt="{{$almacenamientoPrincipal->name}}">
                            </div>
                            {{-- Info Producto --}}
                            <div>
                                <p class="mt-2 mb-2 leading-relaxed">{{$almacenamientoPrincipal->nombre}}</p>
                                <p class="mt-2 mb-2 text-verde">{{$almacenamientoPrincipal->category->nombre_categoria}}</p>
                                <p class="mt-2 mb-2 font-['roboto'] font-normal">
                                  ${{ (100 - $almacenamientoPrincipal->descuento) * 0.01 * $almacenamientoPrincipal->precio }} MXN
                                  @if ( $almacenamientoPrincipal->descuento > 0 )
                                      <span class="font-normal shadow-xl text-zinc-400 line-through">${{ $almacenamientoPrincipal->precio }}</span>
                                      <span class="font-['roboto'] font-normal text-base text-red-600 py-1.5 px-1.5 bg-red-200 rounded-xl">-{{ $almacenamientoPrincipal->descuento }}% </span>
                                  @endif
                                </p>
                            </div>
                            <form action="{{route('configuradorpc.add')}}" method="POST">
                              @csrf
                              <input type="hidden" name="id" value="{{ $almacenamientoPrincipal->ID_producto }}">
                              <input type="hidden" name="categoria" value="{{$almacenamientoPrincipal->category->nombre_categoria}}">
                              <button class="py-2 px-4 mt-2 mb-2 bg-azul border border-azul rounded-lg text-white shadow hover:shadow-xl">Seleccionar</button>
                            </form>
                        </div>
                        @endif
                        @endforeach
                  @endif
                </div>
            </section>
            </div>
          </div>

          <!-- 8-Enfriamiento -->
          <h2 id="accordion-color-heading-8">
              <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-blue-600 border border-gray-200 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-color-body-8" aria-expanded="{{ $categoriaFaltante == 'Enfriamiento' ? 'true' : 'false' }}" aria-controls="accordion-color-body-8">
                <span></span>
                <span class="text-blue-600">Enfriamiento</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                </svg>
              </button>
          </h2>
          <div id="accordion-color-body-8" class="hidden" aria-labelledby="accordion-color-heading-8">
            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
              <section class="mt-4 mb-4 flex flex-col justify-center items-center w-full">
                <div>
                    <h3 class="font-medium text-1xl text-center">Seleccionar Enfriamiento:</h3>
                </div>
                {{-- Tarjetas de productos --}}
                <div class="grid grid-cols-3 w-full text-center mt-4 mx-4">    
                    @if(isset($componentesQuery['enfriamientos']))
                        @foreach($componentesQuery['enfriamientos'] as $enfriamientos)
                        @if(($enfriamientos->stock)>0)
                        <div class="border-2 mx-3 my-5 border-gray-200 rounded-lg pt-2 pb-5 px-3 font-medium shadow-xl">
                            {{-- Imagen --}}
                            <div class="px-2 flex justify-center">
                                <img class="flex items-center max-h-40" src="{{ asset('storage/' . json_decode($enfriamientos->url_photo, true)[0] ) }}" alt="{{$enfriamientos->name}}">
                            </div>
                            {{-- Info Producto --}}
                            <div>
                                <p class="mt-2 mb-2 leading-relaxed">{{$enfriamientos->nombre}}</p>
                                <p class="mt-2 mb-2 text-verde">{{$enfriamientos->category->nombre_categoria}}</p>
                                <p class="mt-2 mb-2 font-['roboto'] font-normal">
                                  ${{ (100 - $enfriamientos->descuento) * 0.01 * $enfriamientos->precio }} MXN
                                  @if ( $enfriamientos->descuento > 0 )
                                      <span class="font-normal shadow-xl text-zinc-400 line-through">${{ $enfriamientos->precio }}</span>
                                      <span class="font-['roboto'] font-normal text-base text-red-600 py-1.5 px-1.5 bg-red-200 rounded-xl">-{{ $enfriamientos->descuento }}% </span>
                                  @endif
                                </p>
                            </div>
                            <form action="{{route('configuradorpc.add')}}" method="POST">
                              @csrf
                              <input type="hidden" name="id" value="{{ $enfriamientos->ID_producto }}">
                              <input type="hidden" name="categoria" value="{{ $enfriamientos->category->nombre_categoria }}">
                              <button class="py-2 px-4 mt-2 mb-2 bg-azul border border-azul rounded-lg text-white shadow hover:shadow-xl">Seleccionar</button>
                            </form>
                         </div>
                         @endif
                      @endforeach
                  @endif
                </div>
            </section>
            </div>
          </div>

          <!-- 9-FUENTE DE PODER -->
          <h2 id="accordion-color-heading-9">
              <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-blue-600 border border-gray-200 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-color-body-9" aria-expanded="{{ $categoriaFaltante == 'Fuente de poder' ? 'true' : 'false' }}" aria-controls="accordion-color-body-9">
                <span></span>
                <span class="text-blue-600">Fuente de Poder</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                </svg>
              </button>
          </h2>
          <div id="accordion-color-body-9" class="hidden" aria-labelledby="accordion-color-heading-9">
            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
              <section class="mt-4 mb-4 flex flex-col justify-center items-center w-full">
                <div>
                    <h3 class="font-medium text-1xl text-center">Seleccionar Fuente de Poder:</h3>
                </div>
                {{-- Tarjetas de productos --}}
                <div class="grid grid-cols-3 w-full text-center mt-4 mx-4">    
                    @if(isset($componentesQuery['fuentesDePoder']))
                        @foreach($componentesQuery['fuentesDePoder'] as $fuentesDePoder)
                        @if(($enfriamientos->stock)>0)
                        <div class="border-2 mx-3 my-5 border-gray-200 rounded-lg pt-2 pb-5 px-3 font-medium shadow-xl">
                            {{-- Imagen --}}
                            <div class="px-2 flex justify-center">
                                <img class="flex items-center max-h-40" src="{{ asset('storage/' . json_decode($fuentesDePoder->url_photo, true)[0] ) }}" alt="{{$fuentesDePoder->name}}">
                            </div>
                            {{-- Info Producto --}}
                            <div>
                                <p class="mt-2 mb-2 leading-relaxed">{{$fuentesDePoder->nombre}}</p>
                                <p class="mt-2 mb-2 text-verde">{{$fuentesDePoder->category->nombre_categoria}}</p>
                                <p class="mt-2 mb-2 font-['roboto'] font-normal">
                                  ${{ (100 - $fuentesDePoder->descuento) * 0.01 * $fuentesDePoder->precio }} MXN
                                  @if ( $fuentesDePoder->descuento > 0 )
                                      <span class="font-normal shadow-xl text-zinc-400 line-through">${{ $fuentesDePoder->precio }}</span>
                                      <span class="font-['roboto'] font-normal text-base text-red-600 py-1.5 px-1.5 bg-red-200 rounded-xl">-{{ $fuentesDePoder->descuento }}% </span>
                                  @endif
                                </p>
                            </div>
                            <form action="{{route('configuradorpc.add')}}" method="POST">
                              @csrf
                              <input type="hidden" name="id" value="{{ $fuentesDePoder->ID_producto }}">
                              <input type="hidden" name="categoria" value="{{ $fuentesDePoder->category->nombre_categoria }}">
                              <button class="py-2 px-4 mt-2 mb-2 bg-azul border border-azul rounded-lg text-white shadow hover:shadow-xl">Seleccionar</button>
                            </form>
                         </div>
                         @endif
                      @endforeach
                  @endif
                </div>
            </section>
            </div>
          </div>

          <!-- 10-ENSAMBLE -->
          <h2 id="accordion-color-heading-10">
              <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-blue-600 border border-gray-200 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-color-body-10" aria-expanded="{{ $categoriaFaltante == 'Ensamble' ? 'true' : 'false' }}" aria-controls="accordion-color-body-10">
                <span></span>
                <span class="text-blue-600">Ensamble</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                </svg>
              </button>
          </h2>
          <div id="accordion-color-body-10" class="hidden" aria-labelledby="accordion-color-heading-10 grid grid-rows-2 w-full mt-4 mx-4">
            <div class="w-full border border-gray-200 dark:border-gray-700 dark:bg-gray-900 rounded-lg">
                    <div class="flex flex-col items-center">
                        <!-- Label centrado -->
                        <label for="decision" class="mb-4 text-sm font-medium text-base text-gray-900 dark:text-gray-300 text-center">
                            ¿Deseas Ensamblar tu Configuración de PC?
                        </label>
                        <!-- Select centrado -->
                        <select id="decision" name="decision" class="w-1/3 p-2 bg-gray-50 border border-blue-300 text-gray-900 font-medium text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-blue-700 dark:border-gray-600 dark:placeholder-blue-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center">
                            <option class="text-center font-medium text-base" value="si" selected>Sí</option>
                            <option class="text-center font-medium text-base" value="no">No</option>
                        </select>
                    </div>
            </div>
        </div>

      </div>
      

    </div>

    <div class="col-span-1">
      <table class="shadow-sm rounded-lg">
        <thead class="rounded-lg">
            <tr>
                <th class="py-5 px-4 bg-blue-100 font-medium text-normal text-blue-700 border-b border-blue-100 rounded-lg">Productos Seleccionados</th>
            </tr>
        </thead>
        <tbody>
         @if(session()->has('componentesSeleccionados'))
            @php
              $componentes = session('componentesSeleccionados');
            @endphp
            @if(count($componentes)>0)
              @foreach($componentes as $componente)
                <tr class="row">
                    <td class="border-b border-blue-100 rounded-lg">
                        <div class="flex items-center">
                            <div class="cart-pho mr-4">
                                <a href="/productos/{{$componente->ID_producto}}" class="shrink-0">
                                    <img src="{{ asset('storage/' . json_decode($componente->url_photo, true)[0] ) }}" class="size-14" alt="{{$componente->nombre}}">
                                </a>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-green-700">
                                  {{$componente->category->nombre_categoria}}
                                </p>
                                <p class="text-xs">
                                    <b><a href="/productos/{{$componente->ID_producto}}" class="text-sm font-medium text-blue-700 hover:underline dark:text-white">{{$componente->nombre}}</a></b><br>
                                    <b>Modelo: </b>{{$componente->modelo}}<br>
                                    <form action="{{ route('configuradorpc.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$componente->ID_producto}}">
                                        <input type="hidden" name="categoria" value="{{ $componente->category->nombre_categoria }}">
                                        <button class="bg-white-600 text-gray-500 text-xs hover:bg-gray-200 px-2 py-1 rounded"><i class="fa fa-trash"></i> Remover</button>
                                    </form>
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
              @endforeach
            @else
              <tr class="row">
                <td class="border-b border-blue-100 rounded-lg">
                  <div class="text-medium text-gray-500 my-4 mx-2">No hay componentes seleccionados</div>
                </td>
              </tr>
            @endif
          @endif
        </tbody>
      </table>

      <!--Validando que existan componentesSeleccionados>0 para mostrar el boton de remover todos los componentes-->
      @if(session()->has('componentesSeleccionados') && count(session('componentesSeleccionados')) > 0)
        <div class="flex justify-start mt-6">
            <form action="{{ route('configuradorpc.removeAll') }}" method="POST">
                {{ csrf_field() }}
                <button class="bg-white-600 text-gray-500 text-sm hover:bg-gray-200 px-2 py-1 rounded border border-gray-400">
                  <i class="fa fa-trash"></i> Remover Componentes
              </button>
            </form>
        </div>
      @endif
      
      <!--Validando que se encuentre los 8 componentes necesarios seleccionados para poder agregar al carrito los productos-->
      @php
        // Definimos las categorías requeridas
        $categoriasRequeridas = [
            'Procesador',
            'Tarjeta Madre',
            'Memoría RAM',
            'Gabinete',
            'Tarjeta de Video',
            'Disco Duro',
            // 'Almacenamiento Secundario', // Descomentar si también se requiere
            'Enfriamiento',
            'Fuente de poder'
        ];
    
        // Obtenemos los componentes seleccionados de la sesión
        $componentesSeleccionados = session()->get('componentesSeleccionados', []);
  
          // Verificamos si todas las categorías están presentes y no están vacías
        $categoriasCompletas = true;
        foreach ($categoriasRequeridas as $categoria) {
             if (empty($componentesSeleccionados[$categoria])) {
                $categoriasCompletas = false;
                break;
            }
        }
      @endphp

      <div class="text-green-700 font-bold my-4 mx-2">Monto a pagar: ${{$montoTotal}} MXN</div>
      
      @if ($categoriasCompletas)
        <button id="addToCartButton" class="bg-white-600 text-blue-500 text-sm hover:bg-blue-200 px-2 py-1 rounded border border-blue-400" onclick="addToCart()">
            <i class="fa fa-shopping-cart"></i> Agregar al carrito
        </button>
      @endif
    </div>

  </div>

</div>

@endsection

<script>
function addToCart() {

  event.preventDefault(); // Evitar cualquier acción predeterminada del botón

  // Obtener el valor del campo de selección
  let decision = document.getElementById('decision').value;
  console.log(decision); // Verificar el valor del campo

  // Crear un objeto con los datos a enviar
  let data = {
      _token: '{{ csrf_token() }}', // Añadir el token CSRF
      decision: decision
  };

  // Enviar los datos mediante una solicitud AJAX
  fetch('{{ route('configuradorpc.addAll') }}', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}' // Añadir el token CSRF en el encabezado
      },
      body: JSON.stringify(data)
  })
  .then(data => {
        console.log(data);
        // Redirigir a la vista 'cart.index'
        window.location.href = '{{ route('cart.index') }}';
  })
}
</script>
