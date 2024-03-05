<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\bitacoraController;

class cjCajaController extends Controller
{

    public function ListadoCaja()
    {
        try {
            $cajas = DB::table('cjcaja')
                ->where('cajActivo', 1)
                ->get();

            return response()->json($cajas);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener las cajas activas: ' . $e->getMessage()], 500);
        }
    }

    // Crear una nueva caja
    public function CrearCaja(Request $request)
    {
        try {
            $cajNombre = $request->input('txt_cajNombre');
            $cajActivo = $request->input('cajActivo', 1); // Por defecto, la caja se crea activa
            $cajFechaCreacion = now();

            $cajId = DB::table('cjcaja')->insertGetId([
                'cajNombre' => $cajNombre,
                'cajActivo' => $cajActivo,
                'cajFechaCreacion' => $cajFechaCreacion,
            ]);

            return response()->json(['Mensaje' => 'Caja creada con éxito', 'cajId' => $cajId], 201);
        } catch (\Exception $e) {
            return response()->json(['Mensaje' => 'No se logró crear la caja: ' . $e->getMessage()], 409);
        }
    }

    // Actualizar una caja existente
    public function ActualizarCaja(Request $request, $cajId)
    {
        try {
            $cajNombre = $request->input('cajNombre');
            $cajActivo = $request->input('cajActivo', 1); // Por defecto, la caja se actualiza como activa

            $result = DB::table('cjcaja')
                ->where('cajId', $cajId)
                ->update([
                    'cajNombre' => $cajNombre,
                    'cajActivo' => $cajActivo,
                ]);

            if ($result) {
                return response()->json(['Mensaje' => 'Caja actualizada con éxito'], 200);
            } else {
                return response()->json(['Mensaje' => 'No se encontró la caja especificada'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['Mensaje' => 'No se logró actualizar la caja: ' . $e->getMessage()], 409);
        }
    }

    // Eliminar una caja
    public function EliminarCaja($cajId)
    {
        try {
            $result = DB::table('cjcaja')->where('cajId', $cajId)->delete();

            if ($result) {
                return response()->json(['Mensaje' => 'Caja eliminada con éxito'], 200);
            } else {
                return response()->json(['Mensaje' => 'No se encontró la caja especificada'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['Mensaje' => 'No se logró eliminar la caja: ' . $e->getMessage()], 409);
        }
    }

    // public function insertarCaja(Request $request)

    // {

    //     DB::beginTransaction();
    //     try {
    //         // Insertar la nueva transacción de caja en la base de datos
    //         $cjTxnId = DB::table('cjTxn')->insertGetId([
    //             'userId' => $request->userId,
    //             'cjtMontoApertura' => $request->cjtMontoApertura,
    //             'cjtMontoCierre' => $request->cjtMontoCierre,
    //             'cjtFechaApertura' => $request->cjtFechaApertura,
    //             'cjtFechaCierre' => $request->cjtFechaCierre,
    //             'cjtActivo' => $request->cjtActivo,
    //             'cjtFechaCreacion' => now(),
    //         ]);

    //         // Crear instancia del controlador BitacoraController
    //         $bitacoraController = new BitacoraController();

    //         // Agregar el registro en la tabla de bitácora
    //         $bitacoraController->insertarBitacora('cjTxn', $cjTxnId, $request->UsuarioId, 'INSERT', 'Se ha insertado una nueva transacción de caja con ID: ' . $cjTxnId);

    //         // Realizar el commit para guardar los cambios en la base de datos
    //         DB::commit();

    //         // Retornar una respuesta de éxito
    //         return response()->json(['mensaje' => 'Transacción de caja registrada exitosamente']);
    //     } catch (\Exception $e) {
    //         // Realizar el rollback para deshacer los cambios en caso de error
    //         DB::rollback();

    //         // Manejo de la excepción
    //         return response()->json(['error' => 'Error al insertar la transacción de caja: ' . $e->getMessage()], 500);
    //     }
    // }
}
