@extends('admin.layouts.template')

@section('title', 'Dashboard')

@section('content_header')
  <h1>Dashboard</h1>
@endsection

@section('content')
  <p>Bienvenido, <span class="text-azul">{{ Auth::user()->name }}</span> 👋.</p>
@endsection