<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Validator;



class AuthController extends Controller
{
  /**
   * Create user
   *
   * @param  [string] name
   * @param  [string] email
   * @param  [string] password
   * @param  [string] password_confirmation
   * @return [string] message
   * @return [string] idrol
   */
  public function register(Request $request)
  {
    $request->validate([
      'name' => 'required|string',
      // 'email' => 'required|string|email|unique:users',
      'email' => 'required|string|unique:users',
      'password' => 'required|string',
      'c_password' => 'required|same:password',
      'idrol' => 'required|string',
      // 'idusuario_migra'=>'required|string'
    ]);

    $user = new User([
      'name' => $request->name,
      'email' => $request->email,
      'password' => bcrypt($request->password),
      'idrol' => $request->idrol
      // 'idusuario_migra'=>$request->idusuario_migra,
      // 'activo'=>$request->activo
    ]);

    if ($user->save()) {
      return response()->json([
        'message' => 'Successfully created user!'
      ], 201);
    } else {
      return response()->json(['error' => 'Provide proper details']);
    }
  }

  public function ModificaUsuario(Request $request)
  {
    $idusuario = $request->idusuario;
    $idperfil = $request->idperfil;
    $email = $request->email;
    $password = bcrypt($request->password);
    try {
      DB::beginTransaction();
      $query_c = DB::select("UPDATE users set users.email='$email', users.password='$password',users.idrol=$idperfil where users.id=$idusuario;");
      DB::commit();
      return response()->json(['meensaje' => 'Modificacion Exitosa'], 201);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json(['Mensaje' => 'error']);
    }
  }

  public function ModificaUsuarioPerfil(Request $request)
  {
    $idusuario = $request->idusuario;
    $idperfil = $request->idperfil;
    $email = $request->email;
    try {
      DB::beginTransaction();
      $query_c = DB::select("UPDATE users set users.email='$email',users.idrol=$idperfil where users.id=$idusuario;");
      DB::commit();
      return response()->json(['meensaje' => 'Modificacion Exitosa'], 201);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json(['Mensaje' => 'error']);
    }
  }

  public function Solicitapass(Request $request)
  {

    $request->validate([
      'email' => 'required|string',
      'password' => 'required|string',
    ]);
    $credentials = request(['email', 'password']);
    if (!Auth::attempt($credentials)) {
      return response()->json([
        'message' => 'Sin Autorizaciòn'
      ], 401);
    } else {
      return response()->json([
        'mensaje' => 'Autorizado'
      ], 201);
    }
  }
  public function usuarioPerfil(Request $request)
  {
    $nombreUsuario = $request->nombreUsuario;
    try {
      DB::beginTransaction();
      $query_c = DB::select("SELECT * FROM vi_usuario_perfil AS a WHERE a.NOMBRE='$nombreUsuario'");
      DB::commit();
      return response()->json($query_c, 200);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json(['Mensaje' => 'error']);
    }
  }
  public function login(Request $request)
  {

    $request->validate([
      'email' => 'required|string',
      'password' => 'required|string',
      'remember_me' => 'boolean'
    ]);


    $credentials = request(['email', 'password']);
    if (!Auth::attempt($credentials)) {
      return response()->json([
        'message' => 'Sin Autorizaciòn'
      ], 401);
    } else {
      $user = $request->user();

      if ($user->activo === 0) {
        // El usuario no está activo, devuelve una respuesta de error
        return response()->json([
          'message' => 'Usuario Inactivo'
        ], 401);
      }
      $tokenResult = $user->createToken('Acceso al Personal');

      $token = $tokenResult->token;
      if ($request->remember_me)
        $token->expires_at = Carbon::now()->addWeeks(1);
      $token->save();
      return response()->json([
        'logueado' => $user,
        'access_token' => $tokenResult->accessToken,
        'token_type' => 'Bearer',
        'message' => "Exito",
        'expires_at' => Carbon::parse(
          $tokenResult->token->expires_at
        )->toDateTimeString(),

      ]);
    }
  }
  // public function user(Request $request)
  // {
  //   $user = Auth::user();

  //   // Realizar una consulta SQL para obtener el nombre del rol
  //   $rolNombre = DB::table('users')
  //     ->join('rol', 'users.idrol', '=', 'rol.idrol')
  //     ->where('users.id', $user->id)
  //     ->value('rol.nombre');

  //   // Agregar el nombre del rol a los datos del usuario
  //   $user->rol_nombre = $rolNombre;

  //   return response()->json($user);
  // }
  public function user(Request $request)
  {
    // Obtén el usuario actual
    $user = $request->user();

    // Carga la relación con la tabla 'rol' usando una consulta
    $userWithRol = DB::table('users')
      ->join('rol', 'users.idrol', '=', 'rol.idrol')
      ->select('users.*', 'rol.nombre AS nombre_rol')
      ->where('users.id', $user->id)
      ->first();

    // Retorna la respuesta JSON con la relación cargada
    return response()->json($userWithRol);
  }
  public function logout(Request $request)
  {


    $request->session()->invalidate();
    $request->user()->Token()->revoke();
    $request->session()->regenerateToken();

    // $header = $request->header('Authorization');
    return response()->json(['message' => 'Session Cerrada con exito '], 200);
  }
  public function menu(Request $request)
  {
    $idperfil = $request->idperfil;
    try {
      DB::beginTransaction();
      $query_c = DB::select("SELECT * FROM vi_lista_menu as m where  m.idrol=$idperfil  order by m.orden asc ");
      DB::commit();
      return response()->json($query_c, 200);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json(['error' => 'Error al Cargar el Menu' . $e->getMessage()], 404);
    }
  }

  public function AccesoMenu(Request $request)
  {
    $idperfil = $request->idperfil;
    try {
      DB::beginTransaction();
      // $query_c=DB::select("SELECT * FROM vi_lista_menu as dt  where dt.idperfil=$idperfil and dt.checked='true';");
      $query_c = DB::select("SELECT  a.idacceso , a.idrol , r.nombre as rol , m.nombre_menu , m.icono as m_icono, sub.nombre_submenu , sub.ruta, sub.icono 
                              as sm_icono, sub.favorito , sub.id_menu_padre as padre, a.checked from acceso as a
                                INNER JOIN rol as r on r.idrol=a.idrol
                                INNER JOIN submenu as sub on  a.id_sub_menu=sub.id_submenu
                                INNER JOIN menus as m on m.id=sub.id_menu_padre  
                                WHERE r.idrol=  $idperfil and  a.checked=1 ORDER BY m.orden ASC");
      DB::commit();
      return response()->json($query_c, 200);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json(['Mensaje' => 'error'.$e->getMessage()],404);
    }
  }


  public function PermisoOperacion(Request $request)
  {
    $idrol = $request->idrol;
    try {
      DB::beginTransaction();
      // $query_c=DB::select("SELECT * FROM vi_lista_menu as dt  where dt.idperfil=$idperfil and dt.checked='true';");
      $query_c = DB::select("SELECT * from permiso
        INNER join rol on permiso.idrol=rol.idrol
        INNER JOIN operacion on permiso.idoperacion= operacion.idoperacion WHERE permiso.idrol =$idrol");
      DB::commit();
      return response()->json($query_c, 200);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json(['Mensaje' => 'error' . $e->getMessage()]);
    }
  }








  public function ModificaPerfil(Request $request)
  {
    // UPDATE detalle_perfil set detalle_perfil.activo=true  where id_detalle_perfil=45;

    $id_detalle_perfil = $request->id_detalle_perfil;
    $checked = $request->checked;

    try {
      DB::beginTransaction();
      $query_c = DB::select("UPDATE detalle_perfil set detalle_perfil.activo=$checked where id_detalle_perfil=$id_detalle_perfil;");
      DB::commit();
      return response()->json(['meensaje' => 'Modificacion Exitosa'], 201);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json(['Mensaje' => 'error']);
    }
  }
  public function guardaDetallePerfil(Request $request)
  {
    $idperfil = $request->idperfil;
    $idmenu = $request->idmenu;
    $idusuario = $request->idusuario;
    try {
      DB::beginTransaction();
      $query_c = DB::select("INSERT INTO detalle_perfil (idperfil,idmenu,idusuario) VALUES ($idperfil,$idmenu,$idusuario)");
      DB::commit();
      return response()->json(['mensaje' => 'Exitoso'], 201);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json(['Mensaje' => 'error' + $e->getMessage()]);
    }
  }

  public function elminarUsuario(Request $request)
  {
    // UPDATE `users` SET `activo` = '0' WHERE `users`.`id` = 34;
    $idusuario = $request->idusuario;
    try {
      DB::beginTransaction();
      $query_c = DB::select("UPDATE users SET activo = '0' WHERE users.id = $idusuario");
      DB::commit();
      return response()->json(['mensaje' => 'Exitoso'], 201);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json(['Mensaje' => 'error' . $e->getMessage()]);
    }
  }


  public function ModificaAcceso(Request $request)
  {
    $acceco = $request->idacceso;
    $checked = $request->checked;
    try {
      DB::table('acceso')
        ->where('idacceso', $acceco)
        ->update(['checked' => $checked]);

      return response()->json(['mensaje' => 'Actualización exitosa'], 201);
    } catch (\Exception $e) {
      // Manejo de errores, por ejemplo, loggear el error o devolver un mensaje de error.
      return response()->json(['error' => 'Error al actualizar: ' . $e->getMessage()], 500);
    }
  }

  // public function DatosEmpresa()
  // {
  //   try {
  //     $empresa = DB::table('gntempresa')->get();

  //     if ($empresa->isNotEmpty()) {
  //       $empresaUtf8 = $empresa->map(function ($item) {
  //         // Convertir las cadenas a UTF-8 si es necesario
  //         $item->emLogo = base64_encode($item->emLogo);
  //         // Agrega más conversiones para otras columnas si es necesario

  //         return $item;
  //       });

  //       return response()->json($empresaUtf8, 201);
  //     } else {
  //       return response()->json(['Mensaje' => 'No se encontraron datos']);
  //     }
  //   } catch (\Exception $e) {
  //     return response()->json(['error' => 'No se Logró Obtener los Datos de la Empresa: ' . $e->getMessage()], 409);
  //   }
  // }
  public function DatosEmpresa()
  {
      try {
          $empresa = DB::table('gntempresa')
              
              ->get();

          return response()->json($empresa,201);
      } catch (\Exception $e) {
          // return response()->json(['error' => 'Error al obtener los Datos de la Empresa: ' . $e->getMessage()], 500);
          return response()->json(['error' => 'No se Logró realizar la operación de la Venta: ' . $e->getMessage()], 409);
      }
  }
}
