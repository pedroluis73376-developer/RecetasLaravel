<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecetaController extends Controller
{

    public function __invoke(Request $request)
    {
        $receta = [
            'nombre' => 'pizza hawuaiana',
            'descripcion'=>'prepara la mejor pizzaa'
       ];
       return $receta;
    }
}
