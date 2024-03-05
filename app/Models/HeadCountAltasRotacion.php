<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadCountAltasRotacion extends Model
{
    use HasFactory;
    protected $table ='rotacion';
    // protected $id='IdRemuneracion';
    protected $fillable=["idRotacion","mesReporte","headCount","altasReemplazo"];
}
