<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\bitacoraController;
use App\Http\Controllers\InvTxnController;
use App\Http\Controllers\intArticuloController;
use App\Http\Controllers\cjtTxnController;
use App\Http\Controllers\cmdetTxnController;
class cmtxnController extends Controller
{
    //Obtner las compras Realizadas 
    public function GetAllShopping()
    {
        try {
            $dataResults = DB::table('cmtxn')
            ->join('gntproveedor', 'cmtxn.provId', '=', 'gntproveedor.provID')
            ->leftJoin('cmdettxn', 'cmtxn.cmtId', '=', 'cmdettxn.cmdtId')
            ->select(
                'cmtxn.cmtId',
                'cmtxn.cmtNumero',
                DB::raw('CONCAT(gntproveedor.provNombre, " ", gntproveedor.provTelefono) AS nombreProveedor'),
                'cmtxn.cmtFechaCreacion',
                DB::raw('CEIL(SUM(cmdettxn.cmdCantidad * cmdettxn.cmdCosto)) as totalCompras')
            )
            ->where('cmtxn.cmtActivo', 1)
            ->where('cmdettxn.cmdActivo', 1)
            ->groupBy('cmtxn.cmtId', 'cmtxn.cmtNumero', 'gntproveedor.provNombre', 'gntproveedor.provTelefono','cmtxn.cmtFechaCreacion')
            ->orderBy('cmtNumero', 'desc')
            ->get();
            return response()->json($dataResults);
        } catch (\Exception $ex) {
            return response()->json(['mensaje' => 'Error al obtener las Compras Realizadas: ' . $ex->getMessage()], 500);
        }
    }
    public function GetShoppingById(Request $request)
    {
        try {
            $dataResults = DB::table('cmtxn')
            ->join('gntproveedor', 'cmtxn.provId', '=', 'gntproveedor.provID')
            ->select(
                'cmtxn.cmtId',
                'cmtxn.cmtNumero',
                'cmtxn.userId',
                'cmtxn.provId',
                'gntproveedor.provNombre',
                'cmtxn.cmtFechaCompra',

            )
            ->where('cmtxn.cmtActivo', 1)
            ->where('cmtxn.cmtId',$request->cmtId)
            ->first();
            $detalleCompra = DB::table('cmdettxn')
            ->join('intarticulo', 'cmdettxn.artid', '=', 'intarticulo.artId')
            ->select(
                'cmdettxn.artid',
                'intarticulo.artNombre',
                'cmdettxn.cmdCantidad',
                'cmdettxn.cmdCosto'
            )
            ->where('cmdtId',$request->cmtId)->where('cmdActivo',1)->get();
            return response(['data'=>$dataResults,'detalle'=>$detalleCompra]);
            // return response()->json($dataResults);
        } catch (\Exception $ex) {
            return response()->json(['mensaje' => 'Error al obtener la Compra: ' . $ex->getMessage()], 500);
        }
    }
    public function AddShopping(Request $request)
    {
        DB::beginTransaction();
        try {
            $provId = $request->provId;
            $userId = $request->userId;
            $ttxnId = $request->txnId;
            $cmtFechaCompra = $request->cmtFechaCompra;
            $cmtActivo = $request->cmtActivo;

            
            // Verificar si existen compras 
            $cmtNumero = DB::table('cmtxn')->max('cmtNumero');

            if ($cmtNumero === null) {
                // No hay compras, generar el primer número de venta
                $nuevoCmtNumero = 'CM000001';
            } else {
                // Generar el nuevo número de venta en el formato "VE000000"
                $nuevoCmtNumero = 'CM' . str_pad((int)substr($cmtNumero, 2) + 1, 6, '0', STR_PAD_LEFT);
                
            }

            // Obtener detalles de los productos comprados//
            // $detalleCompra = $request->detallesCompra;   //esto se descomenta para probar en postman

            $detalleCompra = json_decode($request->input('detallesCompra'), true);
        
            // Objetos
            $obj_invTxn = new InvTxnController();
            $cmDetTxnController = new cmDetTxnController();
            $bitacoraController = new bitacoraController();
            $intArticuloController = new intArticuloController();
            $obj_cjttxn = new cjtTxnController();
            $tablaCmtTxn = 'cmtxn';
            // Insertar datos en la tabla cmtxn usando el controlador CmtTxnController
            $cmtId = DB::table($tablaCmtTxn)->insertGetId([
                'provId' => $provId,
                'userId' => $userId,
                'ttxnId' => $ttxnId,
                'cmtNumero' => $nuevoCmtNumero,
                'cmtFechaCompra' => $cmtFechaCompra,
                'cmtActivo' => $cmtActivo,
                'cmtFechaCreacion' => now(),
            ]);
            // Insertar detalles de los productos comprados en la tabla cmDetTxn usando el controlador cmDetTxnController
            foreach ($detalleCompra as $detalle) {
                $detalle['cmtId'] = $cmtId; // Asignar el cmtId al detalle para asociarlo a la compra realizada
                $detalle['cmtFechaCompra']=$cmtFechaCompra;
                $cmDetTxn =  $cmDetTxnController->AddDetailShopping(new Request($detalle));
            }
            // Insertar movimiento en inventario usando el controlador InvTxnController
            $Modulo = "Compras";
            $invActivo = 1;
            $respMovimiento = $obj_invTxn->guardarMovimiento(
                now(),
                $ttxnId,
                $nuevoCmtNumero,
                $Modulo,
                $userId,
                $invActivo,
                now(),
                $detalleCompra
            );
            foreach ($detalleCompra as $detalle ) {
                $artId= $detalle['artId'];
                $cmdCantidad= $detalle['cmdCantidad'];
                $intArticuloController->aumentarCantidadArticulo($artId,$cmdCantidad);
            }
            
            // Registrar en la bitácora usando el controlador bitacoraController
            $bitacoraController->insertarBitacora($tablaCmtTxn, $cmtId, $userId, 'Creación de registro', 'Nueva Compra' . "-" . $nuevoCmtNumero);

            DB::commit();
            return response()->json(['mensaje' => 'Compra ' . $nuevoCmtNumero . ' registrada con éxito','cjtReferencia' => $nuevoCmtNumero, 'MensajeMovimientoInv'=>$respMovimiento], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'No se Logró realizar la operación de la Compra: ' . $e->getMessage()], 409);
        }
    }
    public function UpdateShopping(Request $request)
    {
        DB::beginTransaction();
        try {
            $cmtId = $request->cmtId;
            $provId = $request->provId;
            $userId = $request->userId;
            $cmtFechaCompra = $request->cmtFechaCompra;

            // Obtener detalles de los productos comprados//
            // $detalleCompra = $request->detallesCompra;   //esto se descomenta para probar en postman
            $detalleCompra = json_decode($request->input('detallesCompra'), true);

            // Objetos
            $obj_invTxn = new InvTxnController();
            $cmDetTxnController = new cmDetTxnController();
            $bitacoraController = new bitacoraController();
            $intArticuloController = new intArticuloController();
            $obj_cjttxn = new cjtTxnController();
            $tablaCmtTxn = 'cmtxn';
            // Insertar datos en la tabla cmtxn usando el controlador CmtTxnController
            DB::table($tablaCmtTxn)->where('cmtId', $cmtId)->update([
                'provId' => $provId,
                'userId' => $userId,
                'cmtFechaCompra' => $cmtFechaCompra
            ]);
            // Revertir la transaccion
            $resultRollback= $this->RollbackCompras($cmtId,$userId);

            // Insertar detalles de los productos comprados en la tabla cmDetTxn usando el controlador cmDetTxnController
            foreach ($detalleCompra as $detalle) {
                $detalle['cmtId'] = $cmtId; // Asignar el cmtId al detalle para asociarlo a la compra realizada
                $detalle['cmtFechaCompra']=$cmtFechaCompra;
                $cmDetTxn =  $cmDetTxnController->AddDetailShopping(new Request($detalle));
            }
            // Insertar movimiento en inventario usando el controlador InvTxnController
            $Modulo = "Compras";
            $invActivo = 1;
            $nuevoCmtNumero = DB::table($tablaCmtTxn)->where('cmtId', $cmtId)->first();
            $obj_invTxn->guardarMovimiento(
                now(),
                2,
                $nuevoCmtNumero->cmtNumero,
                $Modulo,
                $userId,
                $invActivo,
                now(),
                $detalleCompra
            );
            foreach ($detalleCompra as $detalle ) {
                $artId= $detalle['artId'];
                $cmdCantidad= $detalle['cmdCantidad'];
                $intArticuloController->aumentarCantidadArticulo($artId,$cmdCantidad);
            }
            // Registrar en la bitácora usando el controlador bitacoraController
            $bitacoraController->insertarBitacora($tablaCmtTxn, $cmtId, $userId, 'Actualización de registro', 'Compra Modificada' . "-" . $nuevoCmtNumero->cmtNumero);
            DB::commit();
            return response()->json(['mensaje' => 'Compra ' . $nuevoCmtNumero->cmtNumero . ', Operación realizada exitosamente.','cjtReferencia' => $nuevoCmtNumero->cmtNumero], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'No se Logró realizar la operación de la Compra: ' . $e->getMessage()], 409);
        }
    }
    public function InactiveShopping(Request $request)
    {
        $obj_bitacora = new bitacoraController();
        $UsuarioId = $request->usrId;
        DB::beginTransaction();
        try {
            $tabla = 'cmtxn';
            DB::table($tabla)
                ->where('cmtId', $request->cmtId)
                ->update([
                    'cmtActivo' => 0,
                ]);
            $obj_bitacora->insertarBitacora($tabla, $request->cmtId, $UsuarioId, 'ANULACION', 'Eliminación de Compras');
            $resultRollback= $this->RollbackCompras($request->cmtId, $UsuarioId);
            DB::commit();
            return response()->json(['Mensaje' => 'Operaciòn Realizado con Éxito'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['Mensaje' => 'No se Logró Realizar la Operación: ' . $e->getMessage()], 409);
        }
    }
    public function RollbackCompras($cmtId,$userId)
    {
        $obj_invTxn = new InvTxnController();
        $cmDetTxnController = new cmDetTxnController();
        $bitacoraController = new bitacoraController();
        $intArticuloController = new intArticuloController();
        $obj_cjttxn = new cjtTxnController();

        /** 00.Obtenemos el Nro de Compra */
        $cmtNumero = DB::table('cmtxn')->where('cmtId',$cmtId)->first();

        /** 01.Obtenemos el detalle actual de compras para revertir la cantidad del stock en los articulos */
        $detalleCompra = DB::table('cmdettxn')->where('cmdtId',$cmtId)->where('cmdActivo',1)->get();
        foreach ($detalleCompra as $itemDetalle) {
            $artId = $itemDetalle->artid;
            $Cantidad = $itemDetalle->cmdCantidad;
            $intArticuloController->disminuirCantidadArticulo($artId, $Cantidad);
        }

        /** 02. Inactivamos el detalle de compras con 0=inactivo */
        DB::table('cmdettxn')->where('cmdtId', $cmtId)->where('cmdActivo',1)->update(['cmdActivo' => 0]);

        /** 03. Obtenemos el Id del inventario de compras*/
        $invId = DB::table('invtxn')->where('invReferencia',$cmtNumero->cmtNumero)->where('invActivo',1)->first();

        /** 03. Inactivamos el movimiento de inventario */
        DB::table('invtxn')->where('invId', $invId->invId)->update(['invActivo' => 0]);

        /** 04. Inactivamos el detalle de transacción */
        DB::table('indettxn')->where('invId', $invId->invId)->update(['indActivo' => 0]);

        /** 05. Anulamos el movimiento en CAJA */
        
        $obj_cjttxn->AnularMovimientoCaja($cmtNumero->cmtNumero, $userId);
    }
    public function GetShoppingByProveedorId(Request $request){
        try {
            $dataResults = DB::table('cmdettxn')
            ->join('cmtxn','cmdettxn.cmdtId','=','cmtxn.cmtId')
            ->join('intarticulo', 'cmdettxn.artid', '=', 'intarticulo.artId')
            ->select(
                'cmtxn.cmtNumero',
                'intarticulo.artNombre',
                'cmdettxn.cmdCantidad',
                'cmdettxn.cmdCosto'
            )
            ->where('cmtxn.provId',$request->proveedorId)->where('cmtxn.cmtActivo',1)->where('cmdettxn.cmdActivo',1)
            ->get();
            return response()->json($dataResults,200);
        } catch (\Exception $ex) {
            return response()->json(['mensaje' => 'Error al obtener la Compra: ' . $ex->getMessage()], 500);
        }
    }
}
