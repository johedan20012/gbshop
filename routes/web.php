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
/*
Route::get('/', function () {
    return view('inicio', 'ProductosController@getProductos')->name('produc');
});*/
//Auth::routes();
//Route::get('/productos', 'ProductosController@getProductos')->name('produc');
//Route::get('/verProducto/{id}', 'ProductosController@getProducto')->name('verProducto');


//TODO Rutas de la tienda
Route::get('/','ProductosController@getInicio')->name('inicio'); //?Inicio
Route::get('/catalogo', 'ProductosController@getCatalogoPorCategoria')->name('catalogo');
Route::post('/proPorCat', 'ProductosController@getCatalogoPorCategoria')->name('buscarProductos');
Route::get('/producto', 'ProductosController@getProducto')->name('verProducto');

//Route::view('/login','cliente.login')->name('getLoginCliente')->middleware('guest');
//TODO Proceso de login para clientes
Route::post('/loginCliente','Auth\LoginController@clienteLogin')->middleware('guest')->name('loginCliente');

//TODO Login de admins, la vista y el proceso
Route::view('/loginAdmin','admin.login',['sinNavbar' => True])->name('getLoginAdmin')->middleware('guest'); //? Muestra el form para login
Route::post('/loginAdmin','Auth\LoginController@login')->middleware('guest')->name('loginAdmin');

//TODO Logout de cualquier guard
Route::post('/logout','Auth\LoginController@logout')->name('logout');
Route::get('/logout','Auth\LoginController@logout')->name('logout');

//TODO Rutas de administracion
Route::get('/admin','AdminController@getPanel')->name('admin')->middleware('auth'); //? Muestra el panel de administracion
  //* Rutas de administracion para productos
  Route::post('/admin/tablaProductos','AdminController@getTablaProductos')->name('tablaProductos')->middleware('auth');
  Route::post('/admin/SubCat','AdminController@getSubCategorias')->name('subCat')->middleware('auth');
  Route::post('/admin/regProducto','AdminController@storeProducto')->name('regProducto')->middleware('auth');

  //* Rutas de administracion para marcas
  Route::post('/admin/tablaMarcas','AdminController@getTablaMarcas')->name('tablaMarcas')->middleware('auth');
  Route::post('/admin/regMarca','AdminController@storeMarca')->name('storeMarca')->middleware('auth');
  Route::post('/admin/editMarca','AdminController@editMarca')->name('editMarca')->middleware('auth');
  Route::post('/admin/delMarca','AdminController@delMarca')->name('delMarca')->middleware('auth');

  //* Rutas de administracion para categorias
  Route::post('/admin/tablaCategorias','AdminController@getTablaCategorias')->name('tablaCategorias')->middleware('auth');
  Route::post('/admin/regCategoria','AdminController@storeCategoria')->name('storeCategoria')->middleware('auth');
  Route::post('/admin/editCategoria','AdminController@editCategoria')->name('editCategoria')->middleware('auth');
  Route::post('/admin/delCategoria','AdminController@delCategoria')->name('delCategoria')->middleware('auth');