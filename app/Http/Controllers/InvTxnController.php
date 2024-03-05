<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\bitacoraController;
use App\Http\Controllers\vnDetTxnController;

class InvTxnController extends Controller
{
    //
    public function guardarMovimiento(
        $invFechaMovimiento,
        $ttxId,
        $invReferencia,
        $invModulo,
        $userId,
        $invActivo,
        $invFechaCreacion,
        $detallesMovimiento
    ) {
        $obj_bitacora = new bitacoraController();
        $InDetTxnController = new InDetTxnController();
        // Obtener detalles de los productos involucrados en el movimiento


        DB::beginTransaction();
        try {
            $tablaInvTxn = 'invtxn';
            $invId = DB::table($tablaInvTxn)->insertGetId([
                'invFechaMovimiento' => $invFechaMovimiento,
                'ttxId' => $ttxId,
                'invReferencia' => $invReferencia,
                'invModulo' => $invModulo,
                'userId' => $userId,
                'invActivo' => $invActivo,
                'invFechaCreacion' => $invFechaCreacion,
            ]);
            if (empty($invId)) {
                return response()->json(['mensaje' => 'No se logró realizar la operación: El ID no se Genero Correctamente '], 409);
            } else {
                foreach ($detallesMovimiento as $detalle) {
                    $detalle['invId'] = $invId; // Asignar el invId al detalle para asociarlo al movimiento de inventario
                    if($ttxId == 1){
                        $InDetTxn =  $InDetTxnController->guardarDetalleTransaccion($detalle);
                    } else {
                        $InDetTxn =  $InDetTxnController->guardarDetalleTransaccionCompras($detalle);
                    }                    
                }
                $obj_bitacora->insertarBitacora($tablaInvTxn, $invId, $userId, 'Tipo Transaccion ID' . $ttxId, 'Movimiento en Inventario');
                DB::commit();
                return response()->json(['mensaje' => 'Movimiento registrado con éxito', 'MensajeDetalleTxn'=>$InDetTxn], 201);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'No se logró realizar la operación: ' . $e->getMessage()], 409);
        }
    }
}
