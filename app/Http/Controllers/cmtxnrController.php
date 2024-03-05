<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\bitacoraController;
use App\Http\Controllers\InvTxnController;
use App\Http\Controllers\cmdetTxnController;
use App\Http\Controllers\intArticuloController;


class cmtxnrController extends Controller
{
    // 

    public function guardarCompra(Request $request)
    {
        DB::beginTransaction();
        try {
           
            $userId = $request->userId;
            $provid = $request->provid;
            $ttxId = $request->ttxId;
            $cmtNumero = $request->cmtNumero;
            // $cmtFechaCompra = $request->cmtFechaCompra;
            $cmtActivo = $request->cmtActivo;
            $cmtFechaCreacion = $request->cmtFechaCreacion;

            $detallesCompra = $request->detalleCompra;

            //objetos
            $obj_invTxn = new InvTxnController();
            $bitacoraController = new bitacoraController();
            $intArticuloController = new intArticuloController();
            $cmdetTxnController= new cmdetTxnController();

            foreach($detallesCompra as $detalle){
                $artId = $detalle['artId'];
                $detalle['cmdCantidad'];
            }

            $tabla= 'cmtxn';
                $cmtid= DB::table($tabla)->insertGetId([
                'userId'=>$userId,
                'provID'=>$provid,
                'ttxId'=>$ttxId,
                'cmtNumero' => $cmtNumero,
                'cmtFechaCompra'=> now(),
                'cmtActivo' => 1,
                'cmtFechaCreacion'=> now()
            ]);

            foreach ($detallesCompra  as $detalle ) {
                $detalle['cmtid']=$cmtid;
                $cmdetTxnController->guardarCompra(new Request($detalle));
            }

        $Modulo ="Compra";
        $invActivo=1;
        $obj_invTxn->guardarMovimiento(
            now(),
            $ttxId,
            $cmtid,
            $Modulo,
            $userId,
            $invActivo,
            now(),
            $detallesCompra
        );

        foreach ($detallesCompra as $detalle ) {
            $artId= $detalle['artId'];
            $cmdCantidad= $detalle['cmdCantidad'];
            $intArticuloController->aumentarCantidadArticulo($artId,$cmdCantidad);
        }

        $bitacoraController ->insertarBitacora($tabla,$cmtid,$userId,'Creacion de Registro','Nueva Compra');
        DB::commit();        
        return response()->json(['Mensaje' => 'Compra registrada con éxito'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['Mensaje' => 'No se logró realizar la operación de la Venta: ' . $e->getMessage()], 409);
        }
    }
}
