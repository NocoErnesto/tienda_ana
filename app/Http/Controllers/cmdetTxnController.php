<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class cmdetTxnController extends Controller
{
    public function AddDetailShopping(Request $request)
    {
        $mensajesErroes = [
            'cmtId.numeric' => 'El campo ID de artículo debe ser un número.',
            'artId.numeric' => 'El campo ID del ArticulO debe ser un numero',
            'cmdCantidad.numeric' => 'El campo Cantidad debe ser un número.',
            'cmdCosto.numeric' => 'El campo costo debe ser un número.',
            'cmdCosto.regex' => 'debe ser un nuemro entero o decimal'
        ];
        $datosValidos = $request->validate([
            'cmtId' => 'numeric',
            'artId' => 'numeric',
            'cmdCantidad' => 'numeric',
            'cmdCosto' => 'numeric|regex:/^\d+(\.\d{1,2})?$/'
        ], $mensajesErroes);
        DB::beginTransaction();
        try {
            $tabla = 'cmdettxn';
            DB::table($tabla)->insert([
                'cmdtId' => $datosValidos['cmtId'],
                'artId' => $datosValidos['artId'],
                'cmdCantidad' => $datosValidos['cmdCantidad'],
                'cmdCosto' => $datosValidos['cmdCosto'],
                'cmdFechaCompra' => $request->cmtFechaCompra,
                'cmdActivo' => 1,
                'cmdFechaCreacion' => now(),
            ]);
            DB::commit();
            return response()->json(['Mensaje' => 'Detalle Compra registrado con éxito'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return response()->json(['Mensaje' => 'No se logró realizar la operación: ' . $e->getMessage()], 409);
        }
    }
}
