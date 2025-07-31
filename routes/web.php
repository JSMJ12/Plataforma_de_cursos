<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\DashboardCapacitadorController;
use App\Http\Controllers\DashboardAdministradorController;
use App\Http\Controllers\DashboardParticipanteController;
use App\Http\Controllers\DashboardSecretarioEpsuController;
use App\Http\Controllers\DashboardGraduadoController;
use App\Http\Controllers\DashboardEmpresaController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\ItinerarioController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GraduadosController;
use App\Http\Controllers\TrabajoController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PostulacionController;


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
// Ruta para mostrar todos los cursos activos y manejar la búsqueda
Route::get('/cursos-todos', [HomeController::class, 'cursosTodos'])->name('cursos.todos');

Route::get('/out', function () {
    return view('out');
})->name('out');

Auth::routes();
Route::get('/login/token/{token}', [LoginController::class, 'loginWithToken'])->name('login.token');

Route::get('/dashboard/capacitador', [DashboardCapacitadorController::class, 'index'])->middleware('can:gestionar cursos y asistencia')->name('dashboard_capacitador');
Route::get('/dashboard/admin', [DashboardAdministradorController::class, 'index'])->middleware('can:gestionar todos los aspectos')->name('dashboard_admin');
Route::get('/dashboard/participante', [DashboardParticipanteController::class, 'index'])->middleware('can:ver cursos y asistencia')->name('dashboard_participante');
Route::get('/dashboard/EPSU', [DashboardSecretarioEpsuController::class, 'index'])->middleware('can:control de cursos y pagos')->name('dashboard_secretario_epsu');
Route::get('/dashboard/graduado', [DashboardGraduadoController::class, 'index'])->middleware('can:graduados')->name('dashboard_graduado');
Route::get('/dashboard/empresa', [DashboardEmpresaController::class, 'index'])->middleware('can:empresa')->name('dashboard_empresa');

Route::get('/inicio', [InicioController::class, 'redireccionarDashboard'])->name('inicio');


Route::get('/usuarios', [UsuariosController::class, 'index'])->middleware('can:gestionar todos los aspectos')->name('usuarios.index');
Route::get('/usuarios/{id}', [UsuariosController::class, 'show'])->middleware('can:gestionar todos los aspectos')->name('usuarios.show');
Route::post('/usuarios/store', [UsuariosController::class, 'store'])->name('usuarios.store');
Route::get('/usuarios/create/administrador', [UsuariosController::class, 'create_administrador'])->middleware('can:gestionar todos los aspectos')->name('usuarios.create.administrador');
Route::post('/user/upload-cv', [UsuariosController::class, 'uploadCV'])->name('user.upload.cv')->middleware('auth');

Route::get('/dashboard/admin/capacitadores', [DashboardAdministradorController::class, 'usuarios_capacitadores'])->middleware('can:gestionar todos los aspectos')->name('usuarios.capacitadores');
Route::get('/dashboard/admin/graduados', [DashboardAdministradorController::class, 'usuarios_graduados'])->middleware('can:gestionar todos los aspectos')->name('usuarios.graduados');
Route::get('/dashboard/admin/secretarios', [DashboardAdministradorController::class, 'usuarios_secretarios'])->middleware('can:gestionar todos los aspectos')->name('usuarios.secretarios');

Route::get('usuarios/accept/{id}', [UsuariosController::class, 'accept'])->name('usuarios.accept')->middleware('can:gestionar todos los aspectos');
Route::post('usuarios/changePermission/{id}', [UsuariosController::class, 'changePermission'])->name('usuarios.changePermission')->middleware('can:gestionar todos los aspectos');
Route::get('usuarios/revoke-permission/{id}', [UsuariosController::class, 'revokePermission'])->name('usuarios.revokePermission')->middleware('can:gestionar todos los aspectos');

//cursos
// Listar todos los cursos
route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index')->middleware('auth');
Route::get('/cursos/create', [CursoController::class, 'create'])->name('cursos.create')->middleware('can:gestionar cursos y asistencia');
Route::post('/cursos', [CursoController::class, 'store'])->name('cursos.store')->middleware('auth');
Route::get('/cursos/{curso}', [CursoController::class, 'show'])->name('cursos.show');
Route::get('/cursos/{curso}/edit', [CursoController::class, 'edit'])->name('cursos.edit')->middleware('auth');
Route::put('/cursos/{curso}', [CursoController::class, 'update'])->name('cursos.update')->middleware('auth');
Route::delete('/cursos/{curso}', [CursoController::class, 'destroy'])->name('cursos.destroy')->middleware('auth');
Route::put('/cursos/{id}/finalizar', [CursoController::class, 'finalizarCurso'])->name('cursos.finalizar')->middleware('can:gestionar cursos y asistencia');
Route::put('/cursos/reactivar/{id}', [CursoController::class, 'reactivar'])->name('cursos.reactivar')->middleware('can:gestionar todos los aspectos');

Route::get('/cursos-registrados', [DashboardParticipanteController::class, 'cursosRegistrados'])->name('cursos.registrados');
Route::get('/cursos-finalizados', [DashboardParticipanteController::class, 'cursosFinalizados'])->name('cursos.finalizados');

//itinerarios
Route::resource('itinerarios', ItinerarioController::class);

Route::get('itinerarios/cursos/{id}', [ItinerarioController::class, 'itinerariosCursos'])->name('itinerarios.cursos');
Route::get('itinerarios/data/{cursoId}', [ItinerarioController::class, 'getItinerariosData'])->name('itinerarios.data');

//Registros
Route::resource('registro', RegistroController::class);
Route::post('/aprobacion', [RegistroController::class, 'aprobarCurso'])->middleware('can:gestionar cursos y asistencia')->name('aprobacion');

//Actalizar datos graduados
Route::get('/graduados/actualizar_datos/{id?}', [GraduadosController::class, 'edit1'])->name('graduados.edit1')->middleware('auth');

Route::get('/registro-graduado', [GraduadosController::class, 'create'])->name('graduados.create1');

Route::post('/registro-graduado/store', [GraduadosController::class, 'store'])->name('graduados.store1');

Route::resource('graduados', GraduadosController::class);

//pagos
Route::resource('pagos', PagoController::class);
Route::post('/pagos/validar/{pago}', [PagoController::class, 'validar'])->name('pagos.validar')->middleware('can:control de cursos y pagos');

//Asistencias
Route::middleware(['can:gestionar cursos y asistencia'])->group(function () {
    Route::get('/asistencias', [AsistenciaController::class, 'index'])->name('asistencias.index');
    Route::post('/asistencias', [AsistenciaController::class, 'store'])->name('asistencias.store');
});

// Empresas

Route::get('/empresas', [EmpresaController::class, 'index'])->middleware('can:gestionar todos los aspectos')->name('empresas.index');
Route::get('/empresas/create', [EmpresaController::class, 'create'])->name('empresas.create');
Route::post('/empresas', [EmpresaController::class, 'store'])->name('empresas.store');
Route::put('/empresas/{empresa}', [EmpresaController::class, 'update'])->middleware('can:empresa')->name('empresas.update');
Route::get('/trabajos/{id}/postulaciones', [TrabajoController::class, 'getPostulaciones'])->middleware('can:empresa');


// Trabajos
Route::get('/trabajos/all', [TrabajoController::class, 'trabajos_todos'])->name('trabajos_todos')->middleware('auth');
Route::resource('trabajos', TrabajoController::class)->middleware('auth');
// Postulaciones
Route::resource('postulaciones', PostulacionController::class)->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
