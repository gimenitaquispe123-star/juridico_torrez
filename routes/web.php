<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\TarifaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\CarpetaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TipoPersonaController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\AbogadoExpedienteController;
use App\Http\Controllers\ExpedienteDocumentoController;
use App\Http\Controllers\TipoProcesoController;
use App\Http\Controllers\EstadoProcesoController;
use App\Http\Controllers\PosicionController;
use App\Http\Controllers\ProcesoController;
use App\Http\Controllers\TipoPlantillaController;
use App\Http\Controllers\PlantillaController;
use App\Http\Controllers\ProcesoSeguimientoController;
use App\Http\Controllers\ExpedienteDigitalizadoController;
use App\Http\Controllers\ReciboPagoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\MensajeriaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\EnlaceJuridicoController;
use App\Http\Controllers\BackupController;

Route::get('/', function () {
    return redirect()->route('login'); 
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);



Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


Route::middleware(['auth', 'role:cliente'])->group(function () {
    Route::get('/cliente/dashboard', function () {
        return view('panel-cliente');
    })->name('cliente.dashboard');

    Route::get('/cliente/citas', [ClienteController::class, 'citas'])->name('cliente.citas');
    Route::get('/cliente/documentos', [ClienteController::class, 'documentos'])->name('cliente.documentos');
});
Route::get('clientes/export/excel', [ClienteController::class, 'exportExcel'])->name('clientes.export.excel');

Route::get('clientes/export/pdf', [ClienteController::class, 'exportPdf'])->name('clientes.export.pdf');
Route::get('empleados/export/pdf', [EmpleadoController::class, 'exportPDF'])->name('empleados.export.pdf');

// ✅ RUTAS PDF (ANTES DEL RESOURCE)
Route::get('/expedientes/pdf', [ExpedienteController::class, 'pdfVista'])
    ->name('expedientes.pdfVista');

Route::get('/expedientes/pdf-descargar', [ExpedienteController::class, 'pdfDescargar'])
    ->name('expedientes.pdfDescargar');

    Route::get('/procesos/pdf', [ProcesoController::class, 'pdfVista'])
    ->name('procesos.pdfVista');

Route::get('/usuarios/imprimir/{tipo}', [UsuarioController::class, 'imprimir'])->name('usuarios.imprimir');


Route::resource('documentos', DocumentoController::class);

Route::resource('tarifas', TarifaController::class);
Route::resource('notificaciones', NotificacionController::class);
Route::resource('personas', PersonaController::class);


//RUTAS DE DOCUMNTOS Y CARPETAS 

Route::resource('carpetas', CarpetaController::class);
    Route::resource('documentos', DocumentoController::class)->only(['index','create','store','show','destroy']);
    Route::get('documentos/{id}/download', [DocumentoController::class,'download'])->name('documentos.download');
 Route::post('documentos/{id}/ocr', [DocumentoController::class, 'extraerTextoOCR'])->name('documentos.ocr');


Route::prefix('documentos')->group(function () {
    Route::get('{id}/extraer', [DocumentoController::class, 'formExtraerTexto'])->name('documentos.extraer.form');
    Route::get('{id}/extraerOCR', [DocumentoController::class, 'extraerTextoOCR'])->name('documentos.extraerOCR');
    Route::put('{id}/updateTexto', [DocumentoController::class, 'updateTexto'])->name('documentos.updateTexto');
});

Route::post('documentos/{id}/ocr', [DocumentoController::class, 'extraerTextoOCR'])
     ->name('documentos.ocr');


Route::resource('pagos', PagoController::class);
Route::get('/pagos/historial', [PagoController::class, 'historial'])->name('pagos.historial');


Route::middleware(['auth'])->group(function () {

Route::resource('usuarios', UsuarioController::class);


Route::resource('tipos_personas', TipoPersonaController::class);
Route::resource('departamento', DepartamentoController::class);
Route::resource('enlaces', EnlaceController::class);
Route::resource('expedientes', ExpedienteController::class);
Route::resource('clientes', ClienteController::class);
Route::resource('empleados', EmpleadoController::class);
Route::resource('abogado_expediente', AbogadoExpedienteController::class);
Route::resource('expedientes_documentos', ExpedienteDocumentoController::class)->names([
    'index'   => 'expedientes.documentos.index',
    'create'  => 'expedientes.documentos.create',
    'store'   => 'expedientes.documentos.store',
    'show'    => 'expedientes.documentos.show',
    'edit'    => 'expedientes.documentos.edit',
    'update'  => 'expedientes.documentos.update',
    'destroy' => 'expedientes.documentos.destroy',
]);
});


Route::get('/asignar-abogado/{id_expediente}', [AbogadoExpedienteController::class, 'create'])->name('asignar-abogado.create');
Route::post('/asignar-abogado', [AbogadoExpedienteController::class, 'store'])->name('asignar-abogado.store');
Route::resource('abogado_expediente', App\Http\Controllers\AbogadoExpedienteController::class)->except(['show', 'edit']);

Route::middleware(['auth'])->group(function () {

Route::get('expedientes/{expediente}/documentos/create', [ExpedienteDocumentoController::class, 'create'])
    ->name('expedientes-documentos.create');

Route::resource('expedientes-documentos', ExpedienteDocumentoController::class)->except(['create']);


Route::resource('posiciones', PosicionController::class)->parameters([
    'posiciones' => 'posicion'
]);

Route::resource('tipos_proceso', TipoProcesoController::class);

Route::resource('estados_proceso', EstadoProcesoController::class);
Route::resource('procesos', ProcesoController::class);
Route::resource('tipo_plantilla', TipoPlantillaController::class);
Route::resource('plantillas', PlantillaController::class);
Route::post('plantillas/{id}/duplicar', [PlantillaController::class, 'duplicar'])->name('plantillas.duplicar');
Route::get('plantillas/ver-pdf/{id}', [PlantillaController::class, 'verPDF'])->name('plantillas.verPDF');

});


Route::prefix('seguimientos')->group(function () {
    Route::get('/', [ProcesoSeguimientoController::class, 'index'])->name('seguimientos.index');
    Route::get('/create', [ProcesoSeguimientoController::class, 'create'])->name('seguimientos.create');
    Route::post('/', [ProcesoSeguimientoController::class, 'store'])->name('seguimientos.store');
    Route::get('/{seguimiento}', [ProcesoSeguimientoController::class, 'show'])->name('seguimientos.show');
    Route::get('/{seguimiento}/edit', [ProcesoSeguimientoController::class, 'edit'])->name('seguimientos.edit');
    Route::put('/{seguimiento}', [ProcesoSeguimientoController::class, 'update'])->name('seguimientos.update');
    Route::delete('/{seguimiento}', [ProcesoSeguimientoController::class, 'destroy'])->name('seguimientos.destroy');
});


Route::get('procesos/{proceso}/seguimientos', [ProcesoSeguimientoController::class, 'indexPorProceso'])
    ->name('procesos.seguimiento');
 
    // Rutas CRUD completas para seguimientos de procesos
Route::resource('procesos_seguimiento', ProcesoSeguimientoController::class);
Route::get('/procesos_seguimiento/cliente/{cliente}', [App\Http\Controllers\ProcesoSeguimientoController::class, 'porCliente'])
    ->name('procesos_seguimiento.cliente');


Route::resource('expedientes_digitalizados', ExpedienteDigitalizadoController::class);
Route::get('expedientes_digitalizados/{id}/ocr', [ExpedienteDigitalizadoController::class, 'extraerOCR'])
     ->name('expedientes_digitalizados.mostrar.ocr');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::delete('/expedientes_digitalizados/{expedienteDigitalizado}', [ExpedienteDigitalizadoController::class, 'destroy'])->name('expedientes_digitalizados.destroy');

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);


Route::get('expedientes/{id}', [ExpedienteController::class, 'show'])->name('expedientes.show');

Route::resource('recibos_pagos', ReciboPagoController::class);

    Route::resource('citas', CitaController::class);

Route::get('/documentos/generar/{plantilla}', [DocumentoController::class, 'generar'])->name('documentos.generar');
Route::post('/documentos/subir/{plantilla}', [DocumentoController::class, 'subir'])->name('documentos.subir');

Route::get('/documentos/generar/{id}', [DocumentoController::class, 'generar'])->name('documentos.generar');
Route::get('/expedientes_digitalizados/{id}/ocr', [ExpedienteDigitalizadoController::class, 'extraerOCR'])
    ->name('expedientes_digitalizados.ocr');
    Route::put('/expedientes-digitalizados/{id}/texto', [ExpedienteDigitalizadoController::class, 'actualizarTexto'])
    ->name('expedientes_digitalizados.actualizarTexto');


Route::middleware(['auth'])->group(function () {

    Route::get('mensajeria', [MensajeriaController::class, 'index'])->name('mensajeria.index');
    Route::get('mensajeria/create', [MensajeriaController::class, 'create'])->name('mensajeria.create');
    Route::post('mensajeria', [MensajeriaController::class, 'store'])->name('mensajeria.store');
    Route::get('mensajeria/enviar/{id}', [MensajeriaController::class, 'enviarWhatsApp'])->name('mensajeria.enviar');
    Route::get('mensajeria/{id}', [MensajeriaController::class, 'show'])->name('mensajeria.show');

});
Route::get('mensajeria/email/{id}', [MensajeriaController::class,'enviarEmail'])
    ->name('mensajeria.enviarEmail');

Route::get('mensajeria/whatsapp/{id}', [MensajeriaController::class,'enviarWhatsApp'])
    ->name('mensajeria.enviarWhatsApp');

Route::get('/usuarios/pdf', [UsuarioController::class, 'vistaPreviaPdf'])->name('usuarios.pdf.vista');
Route::get('usuarios/pdf', [UsuarioController::class, 'pdfVista'])->name('usuarios.pdf.vista');

Route::get('usuarios/pdf/vista', [UsuarioController::class, 'pdfVista'])->name('usuarios.pdf.vista');
Route::get('usuarios/pdf/descargar', [UsuarioController::class, 'pdfDescargar'])->name('usuarios.pdf.descargar');

// Rutas personalizadas para reporte
Route::get('/pagos/reportes/anual', [PagoController::class, 'reporteAnual'])->name('pagos.reporte.anual');


Route::get('/pagos/reportes/anual/{year}', [PagoController::class, 'reporteAnual'])->name('pagos.reporte.anual.filtrar');
Route::get('pagos/reportes/mensual', [PagoController::class, 'reporteMensual'])
     ->name('pagos.reporte.mensual');
// Exportar reporte anual PDF
Route::get('pagos/reportes/anual/pdf/{year}', [PagoController::class, 'exportarAnualPDF'])
     ->name('pagos.reporte.anual.pdf');

// Exportar reporte mensual PDF
Route::get('pagos/reportes/mensual/pdf/{year}/{month}', [PagoController::class, 'exportarMensualPDF'])
     ->name('pagos.reporte.mensual.pdf');

   Route::get('documentos/usar-plantilla', [DocumentoController::class, 'usarPlantilla'])->name('documentos.usarPlantilla');
Route::get('/pagos/{id_pago}/recibo', 
    [App\Http\Controllers\ReciboController::class, 'generarRecibo'])
    ->name('pagos.recibo');
    Route::post('expedientes/{id}/documentos', [ExpedienteController::class, 'uploadDocumento'])->name('expedientes.documentos.upload');

    Route::post('/plantillas/usar', [PlantillaController::class, 'usar'])->name('plantillas.usar');
Route::get('/documento/{id}/editar', [DocumentoController::class, 'editar'])->name('documento.editar');

Route::post('/documento/{id}/guardar', [DocumentoController::class, 'guardar'])->name('documento.guardar');


Route::group(['middleware' => ['auth']], function () {

    // Roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');


    // Asignar permisos a un rol
    Route::get('/roles/{role}/permissions', [RoleController::class, 'permissions'])->name('roles.permissions');
    Route::put('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');

    // Permisos
Route::get('/permisos', [PermissionController::class, 'index'])->name('permisos.index');
Route::get('/permisos/create', [PermissionController::class, 'create'])->name('permisos.create');
Route::post('/permisos', [PermissionController::class, 'store'])->name('permisos.store');

Route::get('/permisos/{id}/edit', [PermissionController::class, 'edit'])->name('permisos.edit');
Route::put('/permisos/{id}', [PermissionController::class, 'update'])->name('permisos.update');

Route::delete('/permisos/{id}', [PermissionController::class, 'destroy'])->name('permisos.destroy');

});

Route::resource('expedientes_digitalizados', ExpedienteDigitalizadoController::class);
Route::post('expedientes_digitalizados/multiple', [ExpedienteDigitalizadoController::class, 'storeMultiple'])
    ->name('expedientes_digitalizados.storeMultiple');
Route::get('/expedientes/get-codigo/{id}', [ExpedienteController::class, 'getCodigo'])->name('expedientes.get-codigo');

  
Route::get('expedientes_digitalizados/pdf/{nombreArchivo}', [ExpedienteDigitalizadoController::class, 'verPDF'])
    ->name('expedientes_digitalizados.verPDF');
Route::get('documentos/descargar/{id}', [DocumentoController::class, 'descargar'])
    ->name('documentos.descargar');
Route::get('documentos/ver/{id}', [DocumentoController::class, 'ver'])
    ->name('documentos.ver');

   Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');
    Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
});


Route::middleware(['auth'])->group(function () {

Route::get('expedientes/ver/{nombreArchivo}', [ExpedienteDigitalizadoController::class, 'verPDF'])
     ->name('expedientes_digitalizados.verPDF');

Route::resource('enlaces', EnlaceJuridicoController::class);

// Mostrar formulario para solicitar enlace
Route::get('/forgot-password', [\App\Http\Controllers\PasswordResetController::class, 'requestForm'])
    ->name('password.request');

// Enviar correo con enlace
Route::post('/forgot-password', [\App\Http\Controllers\PasswordResetController::class, 'sendEmail'])
    ->name('password.email');

// Formulario para escribir nueva contraseña
Route::get('/reset-password/{token}', [\App\Http\Controllers\PasswordResetController::class, 'resetForm'])
    ->name('password.reset');

// Guardar nueva contraseña
Route::post('/reset-password', [\App\Http\Controllers\PasswordResetController::class, 'updatePassword'])
    ->name('password.update');

    Route::get('/backup', [BackupController::class, 'run'])->name('backup.run');
    Route::get('/backups', [BackupController::class, 'index'])->name('backup.index');
    Route::get('/backup/download/{file}', [BackupController::class, 'download'])
    ->name('backup.download');

    Route::delete('/expedientes/{id}/respaldo', [ExpedienteController::class, 'eliminarRespaldo'])
    ->name('expedientes.respaldo.delete');

Route::delete('/documentos/{id}', [DocumentoController::class, 'destroy'])
    ->name('documentos.delete');

    });
    Route::get('pagos/historial/{cliente}/{tarifa}', 
    [PagoController::class, 'historial']
)->name('pagos.historial');

Route::post('/documentos/{id}/guardar-nuevo-ocr',
    [DocumentoController::class, 'guardarNuevoOCR'])
    ->name('documentos.guardarNuevoOCR');

    
