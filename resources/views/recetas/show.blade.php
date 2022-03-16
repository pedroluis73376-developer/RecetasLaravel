@extends('layouts.app')

@section('content')

{{-- <h1>{{$receta}}</h1> --}}
<article class="contenido-receta">
    <h1 class="text center">{{$receta->titulo}}</h1>

    <div class="imagen-receta">
        <img src="/storage/{{$receta->imagen}}" alt="" class="w-100">
    </div>

    <div class="receta-meta mt-2">
        <p>
            <span class="font-weight-bold text-primary">
                Escrito en: {{$receta->categoria->nombre}}
            </span>
        </p>
        <p>
            <span class="font-weight-bold text-primary">Fecha:</span>
            @php
            $fecha = $receta->created_at;
            @endphp
            <fecha-receta fecha="{{$fecha}}">

            </fecha-receta>
        </p>



        <span class="font-weight-bold text-primary">
            {{--TODO: mostrar el usuario --}}
            Autor: {{$receta->autor->name}}
        </span>
    </div>

    <div class="ingredientes">
        <h3 class="my-3 text-primary"> ingredientes</h3>
        {!!$receta->ingredientes!!}
    </div>

    <div class="preparacion">
        <h3 class="my-3 text-primary"> preparacion</h3>
        {!!$receta->preparacion!!}
    </div>
</article>
@endsection