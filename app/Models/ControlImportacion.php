<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ControlImportacion extends Model
{
    use HasFactory;

    protected $table ='control_importacion';
    // protected $id='IdRemuneracion';
    protected $fillable=["id","gestion","mes","nota","activo","idUsuario"];

}
