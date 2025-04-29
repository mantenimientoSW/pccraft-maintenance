@extends('adminlte::page')

@section('css')
    {{-- Nunito Sans y Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    {{-- Configurar fuente principal --}}
    <style type="text/css">
        body {
            font-family: "Nunito Sans", sans-serif; /*"Poppins", sans-serif; */
            font-optical-sizing: auto;
            font-weight: 600;
            font-style: normal;
            font-variation-settings:
                "wdth" 100,
                "YTLC" 500;
        }
    </style>

    {{-- Para que funcione Tailwind --}}
    @vite('resources/css/app.css')
@endsection

@section('title')
    @yield('title')
@endsection

@section('content_header')
    @yield('content_header')
@endsection

@section('content')
    @yield('content')
@endsection

@section('js')
    @vite('resources/js/app.js')
    <script src="https://kit.fontawesome.com/5a52c5581a.js" crossorigin="anonymous"></script>
@endsection