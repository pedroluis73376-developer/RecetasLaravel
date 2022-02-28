<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecetaController extends Controller
{

    public function __invoke(Request $request)
    {

        $recetas = ['receta pizza', 'receta hamburguesa', 'receta tacos'];
        $categoria = ['comida mexicana','comida argentina', 'postres'];


       // return view('recetas.index')
       // -> with('recetas',$recetas) 
      //  -> with('categoria',$categoria);

      return view('recetas.index',compact('recetas','categoria'));
    }
}
