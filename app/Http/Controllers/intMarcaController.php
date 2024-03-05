<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Psy\Command\WhereamiCommand;

class intMarcaController extends Controller
{
    //
    public function agregarMarca(Request $request)
    {
        $marNombre =strtoupper($request->input('txt_marNombre'));
        // Por defecto, la caja se crea activa

        try {


            $marId = DB::table('intmarca')->insertGetId([
                'marNombre' => $marNombre,
                'marActivo' => 1,
                'marFechaCreacion' => now(),
            ]);

            return response()->json(['mensaje' => 'Marca agregada con éxito', 'marId' => $marId], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al agregar marca: ' . $e->getMessage()], 500);
        }
    }

    public function modificarMarca(Request $request)
    {
        $marId = $request->input('Id');
        $marNombre =strtoupper($request->input('txt_marNombre'));
        try {

            DB::table('intmarca')
                ->where('marId', $marId)
                ->update([
                    'marNombre' => $marNombre,
                ]);

            return response()->json(['mensaje' => 'Marca modificada con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al modificar marca: ' . $e->getMessage()], 500);
        }
    }

    public function listarMarca()
    {
        $marca = DB::table('intmarca')->where('marActivo', 1)->get();

        return response()->json($marca, 200);
    }
    public function TraerMarca(Request $request)
    {

        $id = $request->input('Id');
        $marca = DB::table('intmarca')
        ->where('marId', $id)
        ->Where('marActivo',1)->get();

        if (!$marca) {
            return response()->json(['error' => 'Marca no encontrada'], 404);
        }

        return response()->json($marca, 200);
    }
    public function eliminarMarca(Request $request)
    { 
        DB::beginTransaction();
        try {
            $tabla = 'intmarca';
            DB::table($tabla)
                ->where('marId', $request->id)
                ->update([
                    'marActivo' => 0,
                ]);
        
            DB::commit();
            return response()->json(['Mensaje' => 'Realizado con Éxito'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['Mensaje' => 'No se Logró Realizar la Operación: ' . $e->getMessage()], 409);
        }
    }
}
