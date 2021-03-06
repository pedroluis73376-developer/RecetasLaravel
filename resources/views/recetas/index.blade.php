@extends('layouts/app')

@section( 'botones')
<a href="{{route('recetas.create')}}" class="btn btn-primary mr-2">crear receta</a>
@endsection

@section('content')
<h2 class="text-center mb-5">Administra tus recetas</h2>



<div class="col-md-10 mx-auto bg-white p-3">
    <table class="table">
        <thead class="bg-primary text-light ">
            <tr>
                <th scole="col ">Titulo</th>
                <th scole="col ">Categoria</th>
                <th scole="col ">acciones</th>
            </tr>

        </thead>

        <tbody>

            

            @foreach($recetas as $receta)


            <tr>
                <td>{{$receta->titulo}}</td>
                <td>{{$receta->categoria->nombre}}</td>
                <td>

                    <eliminar-receta receta-id={{$receta->id}}>

                    </eliminar-receta>
                    <a href="{{route('recetas.edit', ['receta' => $receta->id])}}"
                        class="btn btn-dark mb-1  d-line">Editar</a>
                    <a href="{{route('recetas.show', ['receta' => $receta->id])}}"
                        class="btn btn-success mb-1 d-line">Ver</a>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection