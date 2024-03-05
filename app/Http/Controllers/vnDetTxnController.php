<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class vnDetTxnController extends Controller
{
    public function guardarDetalleVenta(Request $request)
    {
        // Mensajes de Errores Personalizados
        $mensajesErrores = [
            'vntid.numeric' => 'El campo ID de venta debe ser un número.',
            'artId.numeric' => 'El campo ID de artículo debe ser un número.',
            'vndCantidad.numeric' => 'El campo Cantidad debe ser un número.',
            'vndPrecioVenta.numeric' => 'El campo Precio de venta debe ser un número.',
            'vndPrecioVenta.regex' => 'El campo Precio de venta debe ser un número decimal.',
            'vndDescuento.numeric' => 'El campo Descuento debe ser un número.',
            'vndDescuento.regex' => 'El campo Descuento debe ser un número decimal.',
            'vndActivo.required' => 'El campo Activo es requerido.',
            // 'vndFechaVenta.required' => 'El campo Fecha de Venta es requerido.',
            // 'vndFechaCreacion.required' => 'El campo Fecha de Creación es requerido.',
        ];
        
        // Validacion de campos
        $datosValidados = $request->validate([
            'vntid' => 'numeric',
            'artId' => 'numeric',
            'vndCantidad' => 'numeric',
            'vndPrecioVenta' => 'numeric|regex:/^\d+(\.\d{1,2})?$/',
            'vndDescuento' => 'numeric|regex:/^\d+(\.\d{1,2})?$/',
            'vndActivo' => 'required',
            // 'vndFechaVenta' => 'required',
            // 'vndFechaCreacion' => 'required',
        ], $mensajesErrores);//llamada a los mensajes de Errores en caso de salte una validacion
        DB::beginTransaction();
        try {
            $tabla = 'vndettxn';
            DB::table($tabla)->insert([
                'vntid' => $datosValidados['vntid'],
                'artId' => $datosValidados['artId'],
                'vndCantidad' => $datosValidados['vndCantidad'],
                'vndPrecioVenta' => $datosValidados['vndPrecioVenta'],
                'vndDescuento' => $datosValidados['vndDescuento'],
                'vndActivo' => $datosValidados['vndActivo'],
                'vndFechaVenta' => now(),
                'vndFechaCreacion' => now(),
            ]);
            DB::commit();
            return response()->json(['Mensaje' => 'Detalle de venta registrado con éxito'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['Mensaje' => 'No se logró realizar la operación: ' . $e->getMessage()], 409);
        }
    }
}
