<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\Request;


    Route::get('/', function () { return view('login', ['error' => '', 'usuario' => '', 'clave' => '']); });
	Route::post('inicio', 'controladorVuelos@inicio');
	Route::get('logout', 'controladorVuelos@logout'); 
	
	Route::get('misReservas', function(Request $request) {
								$usuario = $request->session()->get('usuario');
								$plantilla = $request->session()->get('plantilla');
								return view('misReservas', ['usuario' => $usuario, 'plantilla' => $plantilla]);
							});
	
	Route::get('nuevaReserva', function (Request $request) {
									$usuario = $request->session()->get('usuario');
									$plantilla = $request->session()->get('plantilla');
									return view('nuevaReserva', ['usuario' => $usuario, 'plantilla' => $plantilla]);
							});	
	
	Route::get('perfil', function(Request $request) {
							$usuario = $request->session()->get('usuario');
							$plantilla = $request->session()->get('plantilla');
							return view('perfil', ['usuario' => $usuario, 'plantilla' => $plantilla]);
						});

	Route::get("cargarLista",['uses' => 'controladorVuelos@cargarLista']);
	Route::get("eliminarReserva",['uses' => 'controladorVuelos@eliminarReserva']);
	Route::get("buscarReservas",['uses' => 'controladorVuelos@buscarReservas']);
	Route::get("reservaOrdenar",['uses' => 'controladorVuelos@reservaOrdenar']);
	Route::get("actualizar",['uses' => 'controladorVuelos@actualizar']);
	Route::get("cargarOrigen",['uses' => 'controladorVuelos@cargarOrigen']);
	Route::get("cargarDestino",['uses' => 'controladorVuelos@cargarDestino']);
	Route::get("dibujarAsientos",['uses' => 'controladorVuelos@dibujarAsientos']);
	Route::get("dibujarRuta",['uses' => 'controladorVuelos@dibujarRuta']);
	Route::get("reservar",['uses' => 'controladorVuelos@reservar']);
	
	


	
	