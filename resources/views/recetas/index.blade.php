<h1>Recetas</h1>

@foreach($recetas as $key => $receta)
    <li>{{$receta}}</li>
@endforeach

<h2>Categorias</h2>
@foreach($categoria as $key => $c)
    <li>{{$c}}</li>
@endforeach