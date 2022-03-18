<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    //relacion 1:1
    public function user(){
        return $this->belongsTo(User::class);
    }
}
