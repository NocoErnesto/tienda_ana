<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class gntProveedorController extends Controller
{
    //
    public function agregarProveedor(Request $request)
    {
        $provNombre = strtoupper($request->input('provNombre'));
        $provDireccion =strtoupper( $request->input('provDireccion'));
        $provTelefono = $request->input('provTelefono');
        $provActivo = 1; // Por defecto, el proveedor se crea activo

        try {
            $provId = DB::table('gntproveedor')->insertGetId([
                'provNombre' => $provNombre,
                'provDireccion' => $provDireccion,
                'provTelefono' => $provTelefono,
                'provActivo' => $provActivo,
                'provFechaCreacion' => now(),
            ]);

            return response()->json(['mensaje' => 'Proveedor agregado con éxito', 'provId' => $provId], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al agregar proveedor: ' . $e->getMessage()], 500);
        }
    }


    public function modificarProveedor(Request $request)
    {
        $provId = $request->input('provId');
        $provNombre = $request->input('provNombre');
        $provDireccion = $request->input('provDireccion');
        $provTelefono = $request->input('provTelefono');

        try {
            DB::table('gntproveedor')
                ->where('provID', $provId)
                ->update([
                    'provNombre' => $provNombre,
                    'provDireccion' => $provDireccion,
                    'provTelefono' => $provTelefono,
                ]);

            return response()->json(['mensaje' => 'Proveedor modificado con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al modificar proveedor: ' . $e->getMessage()], 500);
        }
    }

    public function listarProveedores()
    {
        $proveedores = DB::table('gntproveedor')->where('provActivo', 1)->get();

        return response()->json($proveedores, 200);
    }

    public function traerProveedor(Request $request)
    {
        $provId = $request->input('provId');
        $proveedor = DB::table('gntproveedor')
            ->where('provID', $provId)
            ->where('provActivo', 1)
            ->get();

        if (!$proveedor) {
            return response()->json(['error' => 'Proveedor no encontrado'], 404);
        }

        return response()->json($proveedor, 200);
    }

    public function eliminarProveedor(Request $request)
    {
        DB::beginTransaction();

        try {
            $provId = $request->input('provId');
            DB::table('gntproveedor')
                ->where('provID', $provId)
                ->update([
                    'provActivo' => 0,
                ]);

            DB::commit();
            return response()->json(['mensaje' => 'Proveedor eliminado con éxito'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al eliminar proveedor: ' . $e->getMessage()], 500);
        }
    }
}
