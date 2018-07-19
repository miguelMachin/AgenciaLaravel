<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class controladorVuelos extends Controller {
	
	///////////////  LOGIN y LOGOUT   //////////////////////////////////////////////////////////
	
	public function inicio (Request $request) {
		$usuario = $request->usuario;
		$plantilla = "css/plantilla1.css";

		if (isset($request->acceder)){
			$registros = DB::select("SELECT * from t_usuarios where usuario =? and clave =?", [$request->usuario,$request->clave]);
			if (count($registros) > 0){
				$nombre = $registros[0]->usuario;
				$request->session()->put('usuario',$usuario);
				//$plantilla = "css/".$registros[0]->plantilla;
				return view ('principal', ['usuario' => $usuario, 'plantilla' => $plantilla]);
			}else
			return view("login",["error"=>"USUARIO O CLAVE INCORRECTO",'usuario' => $usuario,'clave' => $request->clave]);
		}
		if(isset($request->crearUsuario)){
			$registros = DB::select("SELECT * from t_usuarios where usuario =? ", [$request->usuario]);
			if (count($registros) <= 0){
				DB::insert('INSERT INTO t_usuarios (usuario,clave,plantilla) VALUES(?,?,?)',[$usuario,$request->clave,$plantilla]);	
				return view("login",["error"=>"USUARIO CREADO CORRECTAMENTE",'usuario' => $usuario,'clave' => $request->clave]);
			}else{
				return view("login",["error"=>"NOMBRE DE USUARIO EXISTENTE",'usuario' => $usuario,'clave' => $request->clave]);		
			}
			

		}
		
		
	
	}

	
	public function logout (Request $request) {
		$request->session()->flush();
		return redirect('/');
	}
	
	
	
	//////////////// LISTAR RESERVAS ///////////////////////////////////////////////////////////
	public function cargarLista(Request $request){
		$registros = DB::select("SELECT * from t_reservas where usuario =?", [$request->session()->get('usuario')]);
		if ($registros > 0){
			return view("tablaReservas",["registros"=>$registros]);
		}

	}
	public function eliminarReserva(Request $request){
		$ids = $request->ids;
		$ids = explode("-",$ids);
		for ($i=0; $i < count($ids) ; $i++) {
			DB::delete('DELETE FROM t_reservas WHERE idReserva=?',[$ids[$i]]);
		}
		$registros = DB::select("SELECT * from t_reservas where usuario =?", [$request->session()->get('usuario')]);
		return view("tablaReservas",["registros"=>$registros]);
	}
	public function buscarReservas(Request $request){
		$fechaIda = $request->fechaIda;
		$fechaVuelva = $request->fechaVuelta;
		if ($fechaIda != "" && $fechaVuelva != ""){
			$registros = DB::select("SELECT * from t_reservas where usuario =? AND fechaIda >=? AND fechaVuelta<=?;", [$request->session()->get('usuario'),$fechaIda,$fechaVuelta]);
		}
		if ($fechaIda != "" && $fechaVuelva == ""){
			$registros = DB::select("SELECT * from t_reservas where usuario =? AND fechaIda >=?;", [$request->session()->get('usuario'),$fechaIda,]);
		}
		if ($fechaIda == "" && $fechaVuelva != ""){
			$registros = DB::select("SELECT * from t_reservas where usuario =?  AND fechaVuelta<=?;", [$request->session()->get('usuario'),$fechaVuelta]);
		}
		if ($fechaIda == "" && $fechaVuelva == ""){
			$registros = DB::select("SELECT * from t_reservas where usuario =?", [$request->session()->get('usuario')]);
		}
		return view("tablaReservas",["registros"=>$registros]);

	}
	public function reservaOrdenar(Request $request){
		$campo = $request->campo;
		$registros = DB::select("SELECT * from t_reservas where usuario =? ORDER BY ?", [$request->session()->get('usuario'),$campo]);
		return view("tablaReservas",["registros"=>$registros]);
	}

	
	
	
	
		
	//////////////  NUEVA RESERVA ////////////////////////////////////

	public function cargarOrigen(){
		$rutas = array();
		$registros = DB::select("SELECT * from t_rutas");
		for ($i=0; $i < count($registros) ; $i++) { 
			$origen = $registros[$i]->origen;
			if (!in_array($origen,$rutas)){
				array_push($rutas,$origen);
			}
		}
		return view("selectOrigen",["rutas"=>$rutas]);
	}
	public function cargarDestino(Request $request){
		$rutas = array();
		$registros = DB::select("SELECT * from t_rutas where origen=?",[$request->origen]);
		for ($i=0; $i < count($registros) ; $i++) { 
			$destino = $registros[$i]->destino;
			if (!in_array($destino,$rutas)){
				array_push($rutas,$destino);
			}
		}
		return view("selectDestino",["rutas"=>$rutas]);
	}

	
	public function dibujarAsientos (Request $request){
		$asientos = array();
		$origen = $request->origen;
		$destino = $request->destino;
		$fechaIda = $request->fechaIda;
		$fechaVuelta = $request->fechaVuelta;
		if ($origen != "" && $destino != "" &&  $fechaIda != "" && $fechaVuelta != "" ){
			$registros = DB::select("SELECT asiento FROM t_reservas WHERE origen= ? AND destino= ? AND fechaIda= ? AND fechaVuelta= ?",[$origen,$destino,$fechaIda,$fechaVuelta]);
			for ($i=0; $i < count($registros) ; $i++) { 
				array_push($asientos, $registros[$i]->asiento);
			}
			return view("asientosAvion",["asientos"=>$asientos]);
		}
	}
	
	public function dibujarRuta (Request $request) {
		$origen = $request->origen;
		$destino = $request->destino;
		return view("dibujarRuta",["origen"=>$origen, "destino"=>$destino]);
	}

	public function reservar(Request $request){
		$origen = $request->origen;
		$destino = $request->destino;
		$fechaIda = $request->fechaIda;
		$fechaVuelta = $request->fechaVuelta;
		$asiento = $request->asiento;
		$usuario= $request->session()->get('usuario');
		$registros = DB::insert('insert into t_reservas (usuario,origen,destino,fechaIda,fechaVuelta,asiento) values (?,?,?,?,?,?)', [$usuario,$origen,$destino,$fechaIda,$fechaVuelta,$asiento]);
		if ($registros > 0)
			return view("mensajePerfil",["mensaje"=>"Reservado correctamente"]);
		else
			return view("mensajePerfil",["mensaje"=>"Error al reservar"]);
	}
	

	
	/////////////////  CAMBIAR PERFIL   //////////////////////////////////////////////////////////
	
	public function actualizar(Request $request){
		$clave = $request->clave;
		$plantilla = $request->plantilla;
		$registros = DB::update('UPDATE t_usuarios SET clave=?, plantilla=? WHERE usuario=?',[$clave,$plantilla,$request->session()->get('usuario')]);
		if ($registros > 0)
			return view("mensajePerfil",["mensaje"=>"Modificado Correctamente"]);
		else
			return view("mensajePerfil",["mensaje"=>"Error Actualizar"]);
	}

}
