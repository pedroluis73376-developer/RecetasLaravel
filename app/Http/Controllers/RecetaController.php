<?php

namespace App\Http\Controllers;

use App\CategoriaReceta;
use App\Receta;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;




class RecetaController extends Controller
{

    //para realizar la autenticacion del usuario y este no pueda acceder 
    //la pagina si no esta logeado
    public function __construct()
    {

        $this->middleware('auth', ['except' => 'show']); //except se utiliza para el middleware muestre las recetas
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //auth()->User()->recetas->dd();
        $recetas = auth()->User()->recetas;
        return view('recetas.index')->with(compact('recetas'));
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


        //obtener las categorias sin modelo
        // $categorias = DB::table('categoria_recetas')->get()->pluck('nombre','id');

        //obtener las categorias con modelo
        $categorias = CategoriaReceta::all(['id', 'nombre']);

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
        //  dd($request->imagen->store('upload-recetas', 'public'));

        //validacion de los campos del formulario crear recetas
        $data = request()->validate([
            'titulo' => 'required | min:4',
            'categoria' => 'required',
            'preparacion' => 'required',
            'ingredientes' => 'required',
            'imagen' => 'required|image',
        ]);


        //obtener la ruta de la imagen 
        $ruta_imagen = $request->imagen->store('upload-recetas', 'public');
        //resize de la imagen

        $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000, 550);
        $img->save();

        //insercion de datos en DB sin modelo
        // DB::table('recetas')-> insert([
        //     'titulo'=> $data['titulo'],
        //     'ingredientes'=> $data['ingredientes'],
        //     'preparacion'=> $data['preparacion'],
        //     'imagen'=> $ruta_imagen,
        //     'user_id'=> Auth::user()->id,//con este helper obtenemos el ID del usuario
        //     'categoria_id'=> $data['categoria'],

        // ]);

        //insercion de datos con el modelo
        auth()->user()->recetas()->create([
            'titulo' => $data['titulo'],
            'ingredientes' => $data['ingredientes'],
            'preparacion' => $data['preparacion'],
            'imagen' => $ruta_imagen,
            'user_id' => Auth::user()->id, //con este helper obtenemos el ID del usuario
            'categoria_id' => $data['categoria']

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
        return view('recetas.show', compact('receta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        $categorias = CategoriaReceta::all(['id', 'nombre']);

        return view('recetas.edit')->with(compact('categorias', 'receta'));
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
        //revisar el policy
        $this->authorize('update',$receta);

        //se tiene que validar los campos
        $data = request()->validate([
            'titulo' => 'required | min:4',
            'categoria' => 'required',
            'preparacion' => 'required',
            'imagen' => 'image',
        ]);
        //agregamos los campos que deseamos actualizar
        $receta->titulo = $data['titulo'];
        $receta->categoria_id = $data['categoria'];
        $receta->preparacion = $data['preparacion'];


        //detectamos si cambio la imagen
        if ($request['imagen']) {
            //obtener la ruta de la imagen 
            $ruta_imagen = $request->imagen->store('upload-recetas', 'public');
            //resize de la imagen

            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000, 550);
            $img->save();

            //asignar el objeto
            $receta->imagen = $ruta_imagen;
        }

        $receta->save();
        return redirect(action('RecetaController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        //ejecutar el policy
        $this->authorize('delete',$receta);

        //eliminar la receta
        $receta->delete();


        return redirect(action('RecetaController@index'));
    }
}
