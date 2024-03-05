<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// ---------miGerenteDigital---------------
use App\Http\Controllers\intArticuloController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\vntTxnController;
use App\Http\Controllers\cmtxnController;
use App\Http\Controllers\cjCajaController;
use App\Http\Controllers\cjACController;
use App\Http\Controllers\cjtTxnController;
use App\Http\Controllers\intUnidadController;
use App\Http\Controllers\intMarcaController;
use App\Http\Controllers\intCategoriaController;
use App\Http\Controllers\HeadCountController;
use App\Http\Controllers\gntProveedorController;
use App\Http\Controllers\gntClienteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group(['prefix' => 'auth'], function () {

  Route::get('lista',[HeadCountController::class,'lista']);

  Route::post('login', [AuthController::class, 'login']);
  Route::post('register', [AuthController::class, 'register']);
  Route::get('menu', [AuthController::class, 'menu']);
  Route::post('guardaDetallePerfil', [AuthController::class, 'guardaDetallePerfil']);
  Route::post('elminarUsuario', [AuthController::class, 'elminarUsuario']);
  Route::get('usuarioResponsable', [AuthController::class, 'usuarioResponsable']);
  Route::post('ModificaUsuario', [AuthController::class, 'ModificaUsuario']);
  Route::post('ModificaUsuarioPerfil', [AuthController::class, 'ModificaUsuarioPerfil']);
  // Route::post('ModificaPerfil', [AuthController::class, 'ModificaPerfil']);
  Route::post('AccesoMenu', [AuthController::class, 'AccesoMenu']);
  Route::post('PermisoOperacion', [AuthController::class, 'PermisoOperacion']);
  Route::post('ModificaAcceso', [AuthController::class, 'ModificaAcceso']);

  Route::post('Solicitapass', [AuthController::class, 'Solicitapass']);
  Route::get('DatosEmpresa', [AuthController::class, 'DatosEmpresa']);
  //Lista Menus
  // ListaMenu
  Route::get('ListaRol', [MenuController::class, 'ListaRol']);
  Route::post('GuardarPerfil', [MenuController::class, 'GuardarPerfil']);
  //-----------------------------------------------------------------------//
  // Controladores de  miGerenteDigital


  // ------intArticuloController----------
  Route::get('listArticulo', [intArticuloController::class, 'listArticulo']);
  Route::post('listArticuloPagianado', [intArticuloController::class, 'listArticuloPagianado']);
  Route::get('cbxCategoria', [intArticuloController::class, 'cbxCategoria']);
  Route::get('cbxMarca', [intArticuloController::class, 'cbxMarca']);
  Route::get('cbxUnidad', [intArticuloController::class, 'cbxUnidad']);
  Route::get('siguienteCodigo', [intArticuloController::class, 'siguienteCodigo']);
  Route::post('TraeArticulo', [intArticuloController::class, 'TraeArticulo']);
  Route::post('guardarArticulo', [intArticuloController::class, 'guardarArticulo']);
  Route::post('modificarArticulo', [intArticuloController::class, 'modificarArticulo']);
  Route::post('eliminarArticulo', [intArticuloController::class, 'eliminarArticulo']);
  Route::post('buscarPorNombre', [intArticuloController::class, 'buscarPorNombre']);
  Route::post('CantidadCategoria', [intArticuloController::class, 'CantidadCategoria']);
  Route::get('CantidadCategoria_todo', [intArticuloController::class, 'CantidadCategoria_todo']);
  Route::post('listArticuloCatalogo', [intArticuloController::class, 'listArticuloCatalogo']);
  
   
  
  // vntTxnController

  Route::get('obtenerVentasRealizadas', [vntTxnController::class, 'obtenerVentasRealizadas']);
  Route::post('guardarVenta', [vntTxnController::class, 'guardarVenta']);
  Route::get('ListaFormaPago', [vntTxnController::class, 'ListaFormaPago']);
  Route::post('InactiveVenta', [vntTxnController::class, 'InactiveVenta']);
  Route::post('Venta', [vntTxnController::class, 'Venta']);
  Route::post('detalleVenta', [vntTxnController::class, 'detalleVenta']);
  
  // COMPRAS
  Route::get('GetAllShopping', [cmtxnController::class, 'GetAllShopping']);
  Route::post('AddShopping', [cmtxnController::class, 'AddShopping']);
  Route::post('UpdateShopping', [cmtxnController::class, 'UpdateShopping']);
  Route::get('GetShoppingById', [cmtxnController::class, 'GetShoppingById']);  
  Route::post('InactiveShopping', [cmtxnController::class, 'InactiveShopping']);
  Route::get('GetShoppingByProveedorId', [cmtxnController::class, 'GetShoppingByProveedorId']);

  //  cajCaja
  Route::get('ListadoCaja', [cjCajaController::class, 'ListadoCaja']);
  Route::post('CrearCaja', [cjCajaController::class, 'CrearCaja']);


  


  //cjAperturaCierre
  Route::post('AperturaCaja', [cjACController::class, 'AperturaCaja']);
  Route::post('cerrarCaja', [cjACController::class, 'cerrarCaja']);
  Route::get('obtenerAperturasCaja', [cjACController::class, 'obtenerAperturasCaja']);
  Route::post('usuarioTieneCajaAbierta', [cjACController::class, 'usuarioTieneCajaAbierta']);
  /** armamos la ruta para  */
  Route::get('GetBalanceShopping', [cjACController::class, 'GetBalanceShopping']);
  Route::get('GetTotalShoppingInCaja', [cjACController::class, 'GetTotalShoppingInCaja']);
  Route::get('VerifyCajaOpeningShoppings', [cjACController::class, 'VerifyCajaOpeningShoppings']);
  Route::post('cerrarCajaFecha', [cjACController::class, 'cerrarCajaFecha']);
  //cjtTxnController
  Route::post('guardarMovimientoCaja', [CjtTxnController::class, 'guardarMovimientoCaja']);


  //intUnidad
  Route::post('agregarUnidad', [intUnidadController::class, 'agregarUnidad']);
  Route::post('modificarUnidad', [intUnidadController::class, 'modificarUnidad']);
  Route::get('listarUnidades', [intUnidadController::class, 'listarUnidades']);
  Route::post('TraerUnidad', [intUnidadController::class, 'TraerUnidad']);
  Route::post('eliminarUnidad', [intUnidadController::class, 'eliminarUnidad']);


  //intMarca 
  Route::post('agregarMarca', [intMarcaController::class, 'agregarMarca']);
  Route::post('modificarMarca', [intMarcaController::class, 'modificarMarca']);
  Route::get('listarMarca', [intMarcaController::class, 'listarMarca']);
  Route::post('TraerMarca', [intMarcaController::class, 'TraerMarca']);
  Route::post('eliminarMarca', [intMarcaController::class, 'eliminarMarca']);

  //intCategoria
  Route::post('agregarCategoria', [intCategoriaController::class, 'agregarCategoria']);
  Route::post('modificarCategoria', [intCategoriaController::class, 'modificarCategoria']);
  Route::get('listarCategoria', [intCategoriaController::class, 'listarCategoria']);
  Route::post('TraerCategoria', [intCategoriaController::class, 'TraerCategoria']);
  Route::post('eliminarCategoria', [intCategoriaController::class, 'eliminarCategoria']);
  //gtnProveedor
  Route::post('agregarProveedor', [gntProveedorController::class, 'agregarProveedor']);
  Route::post('modificarProveedor', [gntProveedorController::class, 'modificarProveedor']);
  Route::get('listarProveedores', [gntProveedorController::class, 'listarProveedores']);
  Route::post('traerProveedor', [gntProveedorController::class, 'traerProveedor']);
  Route::post('eliminarProveedor', [gntProveedorController::class, 'eliminarProveedor']);
  //gntCliente
  Route::get('ListaCliente', [gntClienteController::class, 'ListaCliente']);
  Route::post('GuaradarCliente', [gntClienteController::class, 'GuaradarCliente']);
  Route::group(['middleware' => 'auth:api'], function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
  });
});
