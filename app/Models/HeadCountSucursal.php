<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadCountSucursal extends Model
{
    use HasFactory;
    protected $table ='vi_headcount_sucursal';
    // protected $id='IdRemuneracion';
    protected $fillable=["gestion","mes","Sucursal","total"];
}
