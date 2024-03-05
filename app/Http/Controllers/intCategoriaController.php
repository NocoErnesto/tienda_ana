<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class intCategoriaController extends Controller
{
    //
    
    //
    public function agregarCategoria(Request $request)
    {
        $catNombre =strtoupper($request->input('txt_catNombre'));
        // Por defecto, la caja se crea activa

        try {


            $catId = DB::table('intcategoria')->insertGetId([
                'catNombre' => $catNombre,
                'catActivo' => 1,
                'catFechaCreacion' => now(),
            ]);

            return response()->json(['mensaje' => 'Categoria agregada con éxito', 'catId' => $catId], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al agregar categoria: ' . $e->getMessage()], 500);
        }
    }

    public function modificarCategoria(Request $request)
    {
        $catId = $request->input('Id');
        $catNombre =strtoupper($request->input('txt_catNombre'));
        try {

            DB::table('intcategoria')
                ->where('catId', $catId)
                ->update([
                    'catNombre' => $catNombre,
                ]);

            return response()->json(['mensaje' => 'Categoria modificada con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al modificar categoria: ' . $e->getMessage()], 500);
        }
    }

    public function listarCategoria()
    {
        $catca = DB::table('intcategoria')->where('catActivo', 1)->get();

        return response()->json($catca, 200);
    }
    public function TraerCategoria(Request $request)
    {

        $id = $request->input('Id');
        $categoria= DB::table('intcategoria')
        ->where('catId', $id)
        ->Where('catActivo',1)->get();

        if (!$categoria) {
            return response()->json(['error' => 'Categoria no encontrada'], 404);
        }

        return response()->json($categoria, 200);
    }
    public function eliminarCategoria(Request $request)
    { 
        DB::beginTransaction();
        try {
            $tabla = 'intcategoria';
            DB::table($tabla)
                ->where('catId', $request->id)
                ->update([
                    'catActivo' => 0,
                ]);
        
            DB::commit();
            return response()->json(['Mensaje' => 'Realizado con Éxito'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['Mensaje' => 'No se Logró Realizar la Operación: ' . $e->getMessage()], 409);
        }
    }
}
