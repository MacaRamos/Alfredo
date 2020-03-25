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


Route::get('/', 'InicioController@index')->name('inicio');
Route::post('/', 'InicioController@index')->name('inicio');
Route::get('buscarCliente', 'InicioController@buscarCliente')->middleware(['auth', 'superadmin'])->name('buscarCliente');
Route::get('buscarServicio', 'InicioController@buscarServicio')->middleware(['auth', 'superadmin'])->name('buscarServicio');
Route::get('agendar', 'InicioController@agendar')->middleware(['auth', 'superadmin'])->name('agendar');
Route::post('agendar', 'InicioController@agendar')->middleware(['auth', 'superadmin'])->name('agendar');

Route::get('seguridad/login', 'Seguridad\LoginController@index')->name('login');
Route::post('seguridad/login', 'Seguridad\LoginController@login')->name('login_post');
Route::get('seguridad/logout', 'Seguridad\LoginController@logout')->name('logout');
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth','superadmin']], function(){
    route::get('','AdminController@index');
    Route::get('permiso', 'PermisoController@index')->name('permiso');
    Route::get('permiso/crear', 'PermisoController@crear')->name('crear_permiso');
    /*RUTAS DEL MENU*/
    Route::get('menu', 'MenuController@index')->name('menu');
    Route::get('menu/crear', 'MenuController@crear')->name('crear_menu');
    Route::post('menu/guardar', 'MenuController@guardar')->name('guardar_menu');
    Route::get('menu/{Men_id}/editar', 'MenuController@editar')->name('editar_menu');
    Route::put('menu/{Men_id}', 'MenuController@actualizar')->name('actualizar_menu');
    Route::post('menu/guardar-orden', 'MenuController@guardarOrden')->name('guardar_orden');
    /*RUTAS ROL*/
    Route::get('rol', 'RolController@index')->name('rol');
    Route::get('rol/crear', 'RolController@crear')->name('crear_rol');
    Route::post('rol/guardar', 'RolController@guardar')->name('guardar_rol');
    Route::get('rol/{Rol_codigo}/editar', 'RolController@editar')->name('editar_rol');
    Route::put('rol/{Rol_codigo}', 'RolController@actualizar')->name('actualizar_rol');
    Route::delete('rol/{Rol_codigo}', 'RolController@eliminar')->name('eliminar_rol');
    /*RUTAS MENU-ROL*/
    Route::get('menu-rol', 'MenuRolController@index')->name('menu_rol');
    Route::post('menu-rol', 'MenuRolController@guardar')->name('guardar_menu_rol');
});

Route::group(['prefix' => 'especialista', 'namespace' => 'Especialista', 'middleware' => ['auth','superadmin']], function(){
    route::get('','EspecialistaController@index')->name('especialista');

    Route::get('/filtrarFuncionario/{Ve_nombre_ven?}', 'EspecialistaController@index')->name('filtrarFuncionario');
    Route::get('/crear', 'EspecialistaController@crear')->name('crear_especialista');
    Route::post('/guardar', 'EspecialistaController@guardar')->name('guardar_especialista');
    Route::get('/{Ve_cod_ven}/editar', 'EspecialistaController@editar')->name('editar_especialista');
    Route::put('/{Ve_cod_ven}', 'EspecialistaController@actualizar')->name('actualizar_especialista');
    Route::delete('/{Ve_cod_ven}/eliminar', 'EspecialistaController@eliminar')->name('eliminar_especialista');
});

Route::group(['prefix' => 'cliente', 'namespace' => 'cliente', 'middleware' => ['auth','superadmin']], function(){
    route::get('','ClienteController@index')->name('cliente');

    Route::get('/filtrarCliente/{Cli_NomCli?}', 'ClienteController@index')->name('filtrarCliente');

    Route::get('/crear', 'ClienteController@crear')->name('crear_cliente');
    Route::post('/guardar', 'ClienteController@guardar')->name('guardar_cliente');
    Route::get('/{Cli_CodCli}/editar', 'ClienteController@editar')->name('editar_cliente');
    Route::put('/{Cli_CodCli}', 'ClienteController@actualizar')->name('actualizar_cliente');
    Route::delete('/{Cli_CodCli}/eliminar', 'ClienteController@eliminar')->name('eliminar_cliente');
});

Route::group(['prefix' => 'servicio', 'namespace' => 'servicio', 'middleware' => ['auth','superadmin']], function(){
    route::get('','ServicioController@index')->name('servicio');
    
    route::get('/selectDinamico/{Gc_fam_cod?}', 'ServicioController@selectDinamico')->name('selectDinamico');

    Route::get('/filtrarServicio/{Art_nom_externo?}/{productosCheckBox?}', 'ServicioController@index')->name('filtrarServicio');

    Route::get('/crear', 'ServicioController@crear')->name('crear_servicio');
    Route::post('/guardar', 'ServicioController@guardar')->name('guardar_servicio');
    Route::get('/{Art_cod}/editar', 'ServicioController@editar')->name('editar_servicio');
    Route::put('/{Art_cod}', 'ServicioController@actualizar')->name('actualizar_servicio');
    Route::delete('/{Art_cod}/eliminar', 'ServicioController@eliminar')->name('eliminar_servicio');
});