<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Psy\Command\WhereamiCommand;

class intUnidadController extends Controller
{
    //
    public function agregarUnidad(Request $request)
    {
        $uniNombre =strtoupper($request->input('txt_uniNombre'));
        // Por defecto, la caja se crea activa

        try {


            $unidadId = DB::table('intunidad')->insertGetId([
                'uniNombre' => $uniNombre,
                'uniActivo' => 1,
                'uniFechaCreacion' => now(),
            ]);

            return response()->json(['mensaje' => 'Unidad agregada con éxito', 'uniId' => $unidadId], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al agregar unidad: ' . $e->getMessage()], 500);
        }
    }

    public function modificarUnidad(Request $request)
    {
        $uniId = $request->input('Id');
        $uniNombre =strtoupper($request->input('txt_uniNombre'));
        try {

            DB::table('intunidad')
                ->where('uniId', $uniId)
                ->update([
                    'uniNombre' => $uniNombre,
                ]);

            return response()->json(['mensaje' => 'Unidad modificada con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al modificar unidad: ' . $e->getMessage()], 500);
        }
    }

    public function listarUnidades()
    {
        $unidades = DB::table('intunidad')->where('uniActivo', 1)->get();

        return response()->json($unidades, 200);
    }
    public function TraerUnidad(Request $request)
    {

        $id = $request->input('Id');
        $unidad = DB::table('intunidad')
        ->where('uniId', $id)
        ->Where('uniActivo',1)->get();

        if (!$unidad) {
            return response()->json(['error' => 'Unidad no encontrada'], 404);
        }

        return response()->json($unidad, 200);
    }
    public function eliminarUnidad(Request $request)
    { 
        DB::beginTransaction();
        try {
            $tabla = 'intunidad';
            DB::table($tabla)
                ->where('uniId', $request->id)
                ->update([
                    'uniActivo' => 0,
                ]);
        
            DB::commit();
            return response()->json(['Mensaje' => 'Realizado con Éxito'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['Mensaje' => 'No se Logró Realizar la Operación: ' . $e->getMessage()], 409);
        }
    }
}
