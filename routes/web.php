<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\DashboardCapacitadorController;
use App\Http\Controllers\DashboardAdministradorController;
use App\Http\Controllers\DashboardParticipanteController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\ItinerarioController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\PagoController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardParticipanteController::class, 'cursosParticipantes'])->name('participante.cursos');

Route::get('/out', function () {
    return view('out');
})->name('out');

Auth::routes();
Route::get('/login/token/{token}', [LoginController::class, 'loginWithToken'])->name('login.token');

Route::get('/dashboard/capacitador', [DashboardCapacitadorController::class, 'index'])->middleware('can:gestionar cursos y asistencia')->name('dashboard_capacitador');
Route::get('/dashboard/admin', [DashboardAdministradorController::class, 'index'])->middleware('can:gestionar todos los aspectos')->name('dashboard_admin');
Route::get('/dashboard/participante', [DashboardParticipanteController::class, 'index'])->middleware('can:ver cursos y asistencia')->name('dashboard_participante');
Route::get('/inicio', [InicioController::class, 'redireccionarDashboard'])->name('inicio');


Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
Route::get('/usuarios/{id}', [UsuariosController::class, 'show'])->name('usuarios.show');
Route::post('/usuarios/store', [UsuariosController::class, 'store'])->name('usuarios.store');
Route::get('/usuarios/create/administrador', [UsuariosController::class, 'create_administrador'])->name('usuarios.create.administrador');

Route::get('/dashboard/admin/capacitadores', [DashboardAdministradorController::class, 'usuarios_capacitadores'])->middleware('can:gestionar todos los aspectos')->name('usuarios.capacitadores');

Route::get('usuarios/accept/{id}', [UsuariosController::class, 'accept'])->name('usuarios.accept');
Route::post('usuarios/changePermission/{id}', [UsuariosController::class, 'changePermission'])->name('usuarios.changePermission');
Route::get('usuarios/revoke-permission/{id}', [UsuariosController::class, 'revokePermission'])->name('usuarios.revokePermission');

Route::get('users/search', [UsuariosController::class, 'searchByDni']);

//cursos
Route::resource('cursos', CursoController::class);

Route::put('/cursos/{id}/finalizar', [CursoController::class, 'finalizarCurso'])->name('cursos.finalizar');
Route::put('/cursos/reactivar/{id}', [CursoController::class, 'reactivar'])->name('cursos.reactivar');
Route::get('/cursos-registrados', [DashboardParticipanteController::class, 'cursosRegistrados'])->name('cursos.registrados');


//itinerarios
Route::resource('itinerarios', ItinerarioController::class);

Route::get('itinerarios/cursos/{id}', [ItinerarioController::class, 'itinerariosCursos'])->name('itinerarios.cursos');
Route::get('itinerarios/data/{cursoId}', [ItinerarioController::class, 'getItinerariosData'])->name('itinerarios.data');

//Registros
Route::resource('registros', RegistroController::class);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//pagos
Route::resource('pagos', PagoController::class);

//registro
Route::resource('registro', RegistroController::class);
