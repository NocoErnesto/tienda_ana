<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\QueryException;

class gntClienteController extends Controller
{
    //
    public $mensajesErrores = [
        'cliNombre.required' => 'El campo Nombre es requerido.',
        'cliNombre.string' => 'El campo Nombre debe ser una cadena de texto.',
        'cliNombre.max' => 'El campo Nombre no debe exceder los 100 caracteres.',

        'cliApp.required' => 'El campo Apellido Paterno es requerido.',
        'cliApp.string' => 'El campo Apellido Paterno debe ser una cadena de texto.',
        'cliApp.max' => 'El campo Apellido Paterno no debe exceder los 100 caracteres.',

        'cliApm.required'=>'El Campo Appellido Materno es requerido',
        'cliApm.string' => 'El campo  Apellido Materno debe ser una cadena de texto.',
        'cliApm.max' => 'El campo  Apellido Materno no debe exceder los 100 caracteres.',

        'cliCedula.required' => 'El Campo Cedula es requerido.',
        'cliCedula.numeric' => 'El campo Cédula debe ser un número.',

        'cliDireccion.required' => 'El Campo Dirección es requerido.',
        'cliDireccion.string' => 'El campo Dirección debe ser una cadena de texto.',
        'cliDireccion.max' => 'El campo Dirección no debe exceder los 300 caracteres.',

        // 'cliRazonSocial.string' => 'El campo Razón Social debe ser una cadena de texto.',
        // 'cliRazonSocial.max' => 'El campo Razón Social no debe exceder los 300 caracteres.',

        'cliTelefono.required' => 'El Campo Requerido es requerido.',
        'cliTelefono.string' => 'El campo Teléfono debe ser una cadena de texto.',
        'cliTelefono.max' => 'El campo Teléfono no debe exceder los 20 caracteres.',

        'cliFechaCreacion.date' => 'El campo Fecha de Creación debe ser una fecha válida.',
    ];
    public function ListaCliente()
    {

        try {
            //code..
            $listaCliente = DB::table(('gntcliente as cli'))
                ->select('cli.*')
                ->where('cli.cliActivo', 1)->get();
            return response()->json(($listaCliente));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener las ventas realizadas: ' . $e->getMessage()], 500);
        }
    }

    public function GuaradarCliente(Request $request)
    {


        try {
            $datosValidados = $request->validate([
                'cliNombre' => 'required|string|max:100',
                'cliApp' => 'required|string|max:100',
                'cliApm' => 'required|string|max:100',
                'cliCedula' => 'numeric',
                'cliDireccion' => 'string|max:300',
                // 'cliRazonSocial' => 'string|max:300',
                'cliTelefono' => 'string|max:20',
                'cliFechaCreacion' => now(),
            ],  $this->mensajesErrores);

            // Agregar campo 'cliActivo' con valor predeterminado de 1 (activo)
            $datosValidados['cliActivo'] = 1;

            $clienteId = DB::table('gntcliente')->insertGetId($datosValidados);

            return response()->json(['mensaje' => 'Regitro Exitoso'], 201);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Error al crear el cliente: ' . $e->getMessage()], 500);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Error de validación: ' . $e->getMessage()], 422);
        }
    }

    public function ModificarCliente(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $datosValidados = $request->validate([
                'cliNombre' => 'required|string|max:100',
                'cliApp' => 'required|string|max:100',
                'cliApm' => 'string|max:100',
                'cliCedula' => 'numeric',
                'cliDireccion' => 'string|max:300',
                'cliRazonSocial' => 'string|max:300',
                'cliTelefono' => 'string|max:20',
                'cliFechaCreacion' => 'date',
            ],  $this->mensajesErrores);

            // Actualizar el registro sin afectar 'cliActivo'
            DB::table('gntcliente')->where('cliId', $id)->update($datosValidados);

            return response()->json(['mensaje' => 'cliId ' . $id . ' Moficación Exitosa'], 200);
            
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al actualizar el cliente: ' . $e->getMessage()], 500);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error de validación: ' . $e->errors()], 422);
        }
    }

    public function EliminarCliente($id)
    {
        try {
            // Actualizar 'cliActivo' a 0 para indicar inactividad
            $affectedRows = DB::table('gntcliente')->where('cliId', $id)->update(['cliActivo' => 0]);

            if ($affectedRows === 0) {
                return response()->json(['error' => 'No se encontró el cliente o ya está inactivo.'], 404);
            }

            return response()->json(null, 204);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Error al desactivar el cliente: ' . $e->getMessage()], 500);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Error de validación: ' . $e->errors()], 422);
        }
    }
}
