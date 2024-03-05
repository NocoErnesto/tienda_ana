<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
class bitacoraController extends Controller
{
    //

    public function insertarBitacora($tabla, $registroId, $usuarioId, $accion, $detalles) {
        DB::table('bitacora')->insert([
            'bitTabla' => $tabla,
            'bitRegistroid' => $registroId,
            'bitUsuarioid' => $usuarioId,
            'bitAccion' => $accion,
            'bitDetalles' => $detalles
        ]);
    }
}
