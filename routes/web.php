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
Route::get('confirmarAgenda/{Age_AgeCod}', 'InicioController@confirmarAgenda')->middleware(['auth', 'superadmin'])->name('confirmarAgenda');
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
    Route::post('menu', 'MenuController@guardar')->name('guardar_menu');
    Route::get('menu/{Men_id}/editar', 'MenuController@editar')->name('editar_menu');
    Route::put('menu/{Men_id}', 'MenuController@actualizar')->name('actualizar_menu');
    Route::post('menu/guardar-orden', 'MenuController@guardarOrden')->name('guardar_orden');
    /*RUTAS ROL*/
    Route::get('rol', 'RolController@index')->name('rol');
    Route::get('rol/crear', 'RolController@crear')->name('crear_rol');
    Route::post('rol', 'RolController@guardar')->name('guardar_rol');
    Route::get('rol/{Rol_codigo}/editar', 'RolController@editar')->name('editar_rol');
    Route::put('rol/{Rol_codigo}', 'RolController@actualizar')->name('actualizar_rol');
    Route::delete('rol/{Rol_codigo}', 'RolController@eliminar')->name('eliminar_rol');
    /*RUTAS MENU-ROL*/
    Route::get('menu-rol', 'MenuRolController@index')->name('menu_rol');
    Route::post('menu-rol', 'MenuRolController@guardar')->name('guardar_menu_rol');
});