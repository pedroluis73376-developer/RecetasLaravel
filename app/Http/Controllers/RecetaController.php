<?php

namespace App\Http\Controllers;

use App\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class RecetaController extends Controller
{

    //para realizar la autenticacion del usuario y este no pueda acceder 
    //la pagina si no esta logeado
    public function __construct()
    {
       $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('recetas.index');    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //todos las consultas se realizan desde el controlador
        //DB::table('categoria_recetas')->get()->pluck('nombre','id')->dd();
        
        $categorias = DB::table('categoria_recetas')->get()->pluck('nombre','id');

        return view('recetas.create')->with(compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //con esta linea se almacena la imagen en una carpeta del servidor
      //  dd($request['imagen']->store('upload-recetas', 'public'));
        //validacion de los campos del formulario crear recetas
        $data = request()->validate([
            'titulo'=>'required | min:8',
            'categoria'=>'required',
            'preparacion'=>'required',
            'ingredientes'=>'required',
            'imagen'=>'required|image',
        ]);
        //obtener la ruta de la imagen 
        $ruta_imagen= $request['imagen']->store('upload-recetas', 'public');

        //insercion de datos en DB
        DB::table('recetas')-> insert([
            'titulo'=> $data['titulo'],
            'ingredientes'=> $data['ingredientes'],
            'preparacion'=> $data['preparacion'],
            'imagen'=> $ruta_imagen,
            'user_id'=> Auth::user()->id,//con este helper obtenemos el ID del usuario
            'categoria_id'=> $data['categoria'],

        ]);
//redireccionando a otra pagina despues de terminar la insercion de datos
        return redirect(action('RecetaController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        //
    }
}
