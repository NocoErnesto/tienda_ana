<?php

namespace App\Http\Controllers;

use App\Models\Headcount;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class HeadCountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function lista()
    {
        try {
            // Ejecutar la consulta SQL
            $query = DB::table('vi_usuario_perfil')->get();

            // Devolver los resultados como una respuesta JSON
            return response()->json($query, 200);
        } catch (\Exception $e) {
            // Captura una excepción de consulta
            return response()->json(['error' => 'Error en la consulta: ' . $e->getMessage()], 500);
        }
    }
 
  
}
