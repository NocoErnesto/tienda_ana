<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CjtTxnController extends Controller
{
    public function guardarMovimientoCaja(Request $request)
    {
        DB::beginTransaction();
        try {

            $bitacoraController = new bitacoraController();
            $mensajesErrores = [
                'cajId.required' => 'El campo ID de caja es requerido.',
                'cajId.numeric' => 'El campo ID de caja debe ser un número.',
                'userId.required' => 'El campo ID de usuario es requerido.',
                'userId.numeric' => 'El campo ID de usuario debe ser un número.',
                'cjtReferencia.required' => 'El campo Referencia debe ser String.',
                'cjtModulo.required' => 'El campo Modulo es requerido',
                'cjtMonto.required' => 'El campo Monto es requerido.',
                'cjtMonto.numeric' => 'El campo Monto debe ser un número.',
                'ttxnId.required' => 'El campo ID de tipo de transacción es requerido.',
                'ttxnId.numeric' => 'El campo ID de tipo de transacción debe ser un número.',
                'cjtFechaTransaccion.required' => 'El campo Fecha de Transacción es requerido.',
                'cjtFechaTransaccion.date' => 'El campo Fecha de Transacción debe ser una fecha válida.',
                'cjtActivo.required' => 'El campo Activo es requerido.',
                'cjtActivo.boolean' => 'El campo Activo debe ser un valor booleano (true o false).',
            ];

            // Validación de campos
            $datosValidados = $request->validate([
                'cajId' => 'required|numeric',
                'userId' => 'required|numeric',
                'cjtReferencia' => 'nullable|string',
                'cjtModulo' => 'nullable|string',
                'cjtMonto' => 'required|numeric',
                'cjtDescripcion' => 'nullable|string',
                'ttxnId' => 'required|numeric',
            ], $mensajesErrores);

            // Insertar el nuevo registro en la tabla cjttxn
            $tabla = "cjttxn";
            $cjtId = DB::table($tabla)->insertGetId([
                'cajId' => $datosValidados['cajId'],
                'userId' => $datosValidados['userId'],
                'cjtReferencia' => $datosValidados['cjtReferencia'],
                'cjtModulo' => $datosValidados['cjtModulo'],
                'cjtMonto' => $datosValidados['cjtMonto'],
                'cjtDescripcion' => $datosValidados['cjtDescripcion'],
                'ttxnId' => $datosValidados['ttxnId'],
                'cjtFechaTransaccion' => now(),
                'cjtActivo' => 1,
                'cjtFechaCreacion' => now(),
            ]);
            $bitacoraController->insertarBitacora($tabla,$cjtId , $datosValidados['userId'], 'Moviento en caja', 'Codigo de Referencia:'.$datosValidados['cjtReferencia']);
            // Retornar una respuesta de éxito
            DB::commit();
            return response()->json(['mensaje' => 'Movimiento de caja registrado exitosamente'], 201);
        } catch (\Exception $e) {
            // Manejo de la excepción
            DB::rollBack();
            return response()->json(['error' => 'Error al registrar el movimiento de caja: ' . $e->getMessage()], 500);
        }
    }
    public function AnularMovimientoCaja($Referncia, $UsuarioId)
    {
        $obj_bitacora = new bitacoraController();
        $UsuarioId = $UsuarioId;
        DB::beginTransaction();
        try {
            $tabla = 'cjttxn';
            DB::table($tabla)
                ->where('cjtReferencia', $Referncia)
                ->update([
                    'cjtActivo' => 0,
                ]);
            $obj_bitacora->insertarBitacora($tabla, $Referncia, $UsuarioId, 'ANULACION', 'Se anula el registro para evitar descuadre de caja');
            DB::commit();
            return response()->json(['Mensaje' => 'Operación Realizado con Éxito'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['Mensaje' => 'No se Logró Realizar la Operación: ' . $e->getMessage()], 409);
        }
    }
    public function GetTotalAmountDayShopping(){
        try {
            $montoVentas = DB::table('cjttxn')
                ->where('cjttxn.cajId', 2)
                ->where('cjttxn.ttxnId', 2) // Suponiendo que 2 es el ID del tipo de transacción de compra
                ->where('cjttxn.cjtActivo', 1)
                ->whereDate('cjttxn.cjtFechaTransaccion', now()->toDateString()) // Compara con la fecha actual
                ->sum('cjttxn.cjtMonto');
            
            return $montoVentas;
        } catch (\Exception $ex) {
            return response()->json(['mensaje' => 'Error al realizar la suma de compras ' . $ex->getMessage()], 500);
        }
    }
}
