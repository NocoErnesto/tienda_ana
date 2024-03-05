<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\bitacoraController;
use Illuminate\Database\QueryException;

class cjACController extends Controller
{
    public function usuarioTieneCajaAbierta(Request $request)
    {
        $cajId = $request->cajId;
        try {
            // Verificar si existe un registro de apertura de caja para el usuario y la caja en el día actual
            $aperturaCajaExistente = DB::table('cjaperturacierre')
                ->where('cajId', $cajId)
                ->whereDate('acFechaApertura', now()->toDateString())
                ->first();

            if ($aperturaCajaExistente == null) {
                if ($cajId == '1') {
                    return response()->json(['mensaje' => 'La caja Ventas no Fue Aperturada'], 201);
                } else {
                    return response()->json(['mensaje' => 'La caja Gastos no Fue Aperturada'], 201);
                }
                // Hay una caja aperturada
            } else {
                return response()->json(['mensaje' => 'cierre'], 202);
            }
        } catch (\Exception $e) {
            return ['error' => 'Error al verificar la apertura de caja: ' . $e->getMessage(), 400];
        }
    }
    public function AperturaCaja(Request $request)
    {
        try {
            $mensajesErrores = [
                'cajId.numeric' => 'El campo ID de caja debe ser un numero.',
                'cajId.not_in' => 'El campo Caja es Obligatorio',
                'cajId.required' => 'El campo ID de caja es requerido.',
                'userId.required' => 'El campo Usuario es requerido.',
                'userId.numeric' => 'El campo ID usuario debe ser un numero .',
                'acMontoApertura.numeric' => 'El campo Monto de Apertura debe ser un número.',
                'acMontoApertura.required' => 'El campo Monto de Apertura es requerido.',
                'acFechaApertura.date' => 'El campo Fecha de Apertura debe ser una fecha válida.',
                'acActivo.numeric' => 'El campo Activo es requerido.',
            ];

            // Validación de campos
            $datosValidados = $request->validate([
                'cajId' => 'required|numeric|not_in:0',
                'userId' => 'required|numeric',
                'acMontoApertura' => 'required|numeric',
                'acFechaApertura' => 'date',
                'acActivo' => 'numeric',
            ], $mensajesErrores);


            //Verificar  si existe una caja sin cerra en fechas pasadas 
            $cajaSinCerrar = DB::table("cjaperturacierre")
                ->where('cajId', $datosValidados['cajId'])
                ->whereNull('acFechaCierre')
                ->first();
            if ($cajaSinCerrar) {
                $acFechaApertura = $cajaSinCerrar->acFechaApertura;
                return response()->json(['error' => 'No es posible realizar una nueva apertura. Existe una apertura de caja pendiente de cierre en fechas.
                ' . $acFechaApertura]);
            }



            // Verificar si ya se abrió la caja en el mismo día
            $cajaAbiertaHoy = DB::table('cjaperturacierre')
                ->where('cajId', $datosValidados['cajId'])
                // ->where('userId', $datosValidados['userId'])//quitar esto ya que todo ingreso Hira a una mis caja
                ->whereDate('acFechaApertura', now()->toDateString())
                ->first();
            if ($cajaAbiertaHoy) {
                return response()->json(['error' => 'Ya se realizó la apertura correspondiente.']);
            }


            DB::beginTransaction();
            // Insertar el nuevo registro en la tabla cjaperturacierre
            $acId = DB::table('cjaperturacierre')->insertGetId([
                'cajId' => $datosValidados['cajId'],
                'userId' => $datosValidados['userId'],
                'acMontoApertura' => $datosValidados['acMontoApertura'],
                'acFechaApertura' => DB::raw('CURRENT_TIMESTAMP'),
                'acActivo' => $datosValidados['acActivo'],
                'acFechaCreacion' => DB::raw('CURRENT_TIMESTAMP'),
            ]);


            // Agregar el registro en la tabla bitácora
            $bitacora = new bitacoraController();
            $bitacora->insertarBitacora('cjaperturacierre', $acId, $datosValidados['userId'], 'Nueva Apertura de Caja', 'Se ha registrado una nueva apertura de caja con ID: ' . $acId);
            DB::commit();
            // Retornar una respuesta de éxito
            return response()->json(['mensaje' => 'Apertura de caja registrada exitosamente'], 201);
        } catch (\Exception $e) {
            // Manejo de la excepción
            DB::rollBack();
            return response()->json(['error' => 'Error al registrar la apertura: ' . $e->getMessage()], 500);
        }
    }
    public function cerrarCaja(Request $request)
    {
        try {
            $mensajesErrores = [
                'cajId.required' => 'El campo ID de caja es requerido.',
                'userId.required' => 'El campo Usuario es requerido.',
                // 'acMontoCierre.required' => 'El campo Monto de Cierre es requerido.',
                // 'acFechaCierre.required' => 'El campo Fecha de Cierre es requerido.',
                // 'acActivo.required' => 'El campo Activo es requerido.',
            ];

            // Validación de campos
            $datosValidados = $request->validate([
                'cajId' => 'required|numeric',
                'userId' => 'required|numeric',
                // 'acMontoCierre' => 'required|numeric',
                // 'acFechaCierre' => 'required|date',
                // 'acActivo' => 'required',
            ], $mensajesErrores);


            // Verificar si existe un registro de cierre activo para esta caja en la fecha actual
            $registroCierre = DB::table('cjaperturacierre')
                ->where('cajId', $datosValidados['cajId'])
                ->whereNotNull('acFechaApertura')
                ->whereNull('acFechaCierre')
                ->where('acActivo', 1)
                ->first();

            if (!$registroCierre) {
                DB::rollBack();
                return response()->json(['error' => 'La caja ya fue cerrada '], 400);
            }
            DB::beginTransaction();
            $ventas = DB::table('vnttxn')
                ->join('vndettxn', 'vnttxn.vntId', '=', 'vndettxn.vntid')
                ->whereDate('vndettxn.vndFechaVenta', '=', now()->toDateString())
                ->where('vnttxn.vntActivo', 1)
                ->select(DB::raw('SUM(IF(vndettxn.vndDescuento = 0, vndettxn.vndCantidad * vndettxn.vndPrecioVenta, vndettxn.vndCantidad * vndettxn.vndDescuento)) AS totalVenta'))
                ->first();
            // echo $montoVentas;
            // Calcular el monto de cierre sumando el monto de apertura y las ventas
            $montoCierre = $ventas->totalVenta;

            // Actualizar el registro de cierre de caja en la tabla cjaperturacierre
            DB::table('cjaperturacierre')
                ->where('acId', $registroCierre->acId)
                ->where('cajId', $datosValidados['cajId'])
                ->whereDate('acFechaApertura', '=', now()->toDateString())
                ->where('acActivo', 1)
                ->update([
                    'acMontoCierre' => $montoCierre,
                    'acFechaCierre' => DB::raw('CURRENT_TIMESTAMP'),
                    'acActivo' => 1,
                ]);

            // Agregar el registro en la tabla bitácora
            $bitacora = new bitacoraController();
            $bitacora->insertarBitacora('cjaperturacierre', $datosValidados['cajId'], $datosValidados['userId'], 'Cierre de Caja', 'Se ha realizado el cierre de caja para la caja con ID: ' . $datosValidados['cajId']);

            DB::commit();

            // Retornar una respuesta de éxito
            return response()->json(['mensaje' => 'Monto de Cierre :' .  $montoCierre], 201);
        } catch (\Exception $e) {
            // Manejo de la excepción
            DB::rollBack();
            return response()->json(['error' => 'Error al realizar el cierre de caja: ' . $e->getMessage()], 500);
        }
    }








    public function cerrarCajaFecha(Request $request)
    {
        try {
            $mensajesErrores = [
                'cajId.required' => 'El campo ID de caja es requerido.',
                'userId.required' => 'El campo Usuario es requerido.',
                //'acMontoCierre.required' => 'El campo Monto de Cierre es requerido.',
                'acFechaApertura.required' => 'El campo Fecha de Apertura es requerido.',
                // 'acActivo.required' => 'El campo Activo es requerido.',
            ];

            // Validación de campos
            $datosValidados = $request->validate([
                'cajId' => 'required|numeric',
                'userId' => 'required|numeric',
                //'acMontoCierre' => 'required|numeric',
                'acFechaApertura' => 'required|date',
                // 'acActivo' => 'required',
            ], $mensajesErrores);

            DB::beginTransaction();
            $ventas = DB::table('vnttxn')
                ->join('vndettxn', 'vnttxn.vntId', '=', 'vndettxn.vntid')
                ->whereDate('vndettxn.vndFechaVenta', '=', $datosValidados['acFechaApertura'])
                ->where('vnttxn.vntActivo', 1)
                ->select(DB::raw('SUM(IF(vndettxn.vndDescuento = 0, vndettxn.vndCantidad * vndettxn.vndPrecioVenta, vndettxn.vndCantidad * vndettxn.vndDescuento)) AS totalVenta'))
                ->first();
            // echo $montoVentas;
            // Calcular el monto de cierre sumando el monto de apertura y las ventas
            $montoCierre = $ventas->totalVenta;

            DB::table('cjaperturacierre')
                ->where(DB::raw('DATE(acFechaApertura)'), '=', $datosValidados['acFechaApertura'])
                ->update([
                    'acMontoCierre' => $montoCierre,
                    'acFechaCierre' => DB::raw('CURRENT_TIMESTAMP'),
                    'acActivo' => 1,
                ]);

            // Agregar el registro en la tabla bitácora
            $bitacora = new bitacoraController();
            $bitacora->insertarBitacora('cjaperturacierre', $datosValidados['cajId'], $datosValidados['userId'], 'Cierre de Caja', 'Se ha realizado el cierre de caja para la caja con ID: ' . $datosValidados['cajId']);

            DB::commit();

            // Retornar una respuesta de éxito
            return response()->json(['mensaje' => 'Monto de Cierre :' .  $montoCierre], 201);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Error al cerrar caja: ' . $e->getMessage()], 500);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error_1' => 'Error de validación: ' . $e->getMessage()], 422);
        }
    }

























    public function obtenerAperturasCaja()
    {
        try {
            $aperturasCaja = DB::table('cjaperturacierre AS ac')
                ->select('ac.*', 'caj.cajNombre AS nombre_caja', 'usr.name AS nombre_usuario')
                ->join('cjcaja AS caj', 'ac.cajId', '=', 'caj.cajId')
                ->join('users AS usr', 'ac.userId', '=', 'usr.Id')
                ->where('ac.acActivo', 1)
                ->get();

            return response()->json($aperturasCaja, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener las aperturas de caja: ' . $e->getMessage()], 500);
        }
    }
    /** Obtner la suma total en caja actual aperturada paras las compras */
    public function GetTotalShoppingInCaja()
    {
        try {
            $montoCompras = DB::table('cjttxn')
                ->join('cjcaja', 'cjcaja.cajId', '=', 'cjttxn.cajId')
                ->join('cjaperturacierre', 'cjaperturacierre.cajId', '=', 'cjcaja.cajId')
                ->whereRaw('cjcaja.`cajId`=2 and cjttxn.`cjtActivo`=1 and cjaperturacierre.`acActivo`=1 and cjttxn.`cjtFechaTransaccion` >= cjaperturacierre.`acFechaApertura`')
                ->sum('cjttxn.cjtMonto');
            return $montoCompras;
        } catch (\Exception $ex) {
            return response()->json(['mensaje' => 'Error al realizar la suma de compras ' . $ex->getMessage()], 500);
        }
    }
    /** Obtener el saldo de caja aperturada para las compras */
    public function GetBalanceShopping()
    {
        try {
            $montoAperturaCajaComprasActual = DB::table('cjaperturacierre AS ac')
                ->join('cjcaja AS caj', 'ac.cajId', '=', 'caj.cajId')
                ->whereRaw('caj.`cajId`=2 AND ac.`acActivo`=1 and ac.`acMontoApertura`>0 and ac.`acMontoCierre`=0')
                ->value('ac.acMontoApertura');

            $totalComprasCajaActual = $this->GetTotalShoppingInCaja();
            $saldoDelDiaActual = $montoAperturaCajaComprasActual - $totalComprasCajaActual;
            return response()->json(['dataSaldoCompras' => $saldoDelDiaActual, 'montoAperturaCompras' => $montoAperturaCajaComprasActual, 'totalComprasCajaActual' => $totalComprasCajaActual, 'fechaActual' => now()->toDateString()], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener las aperturas de caja: ' . $e->getMessage()], 500);
        }
    }
    /** Verifica si tiene habilitado la caja de apertura de gastos (Compras) */
    public function VerifyCajaOpeningShoppings()
    {
        try {
            // Verificar si existe un registro de apertura de caja para el usuario y la caja en el día actual
            $aperturaCajaExistente = DB::table('cjaperturacierre AS ac')
                ->join('cjcaja AS caj', 'ac.cajId', '=', 'caj.cajId')
                ->whereRaw('caj.`cajId`=2 AND ac.`acActivo`=1 and ac.`acMontoApertura`>0 and ac.`acMontoCierre`=0')
                ->first();
            if ($aperturaCajaExistente == null) {
                return response()->json(['mensaje' => 'La caja gastos no fue Aperturada'], 201);
            } else {
                return response()->json(['mensaje' => 'cierre'], 202);
            }
        } catch (\Exception $e) {
            return ['error' => 'Error al verificar la apertura de caja: ' . $e->getMessage(), 400];
        }
    }
}
