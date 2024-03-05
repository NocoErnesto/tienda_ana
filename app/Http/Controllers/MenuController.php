<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ListaRol()
    {
        // Escribe tu consulta SQL
        $consulta = "SELECT * FROM rol";

        // Ejecuta la consulta usando la fachada DB
        $query = DB::select($consulta);

        // Retorna la respuesta en formato JSON
        return response()->json($query, 200);
    }

    public function GuardarPerfil(Request $request)
    {
        $perfil = $request->perfil;
        //INSERT INTO `perfil` (`idperfil`, `nombre_perfil`) VALUES (NULL, 'REPORTE TEST 2');
        $consulta = "INSERT INTO perfil (nombre_perfil) VALUES ('$perfil')";

        $query = DB::select($consulta);
        return response()->json(['Mensaje' => 'Exito'], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
