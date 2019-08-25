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
Route::post('/proPorCat', 'ProductosController@getProductosPorCategoria')->name('productosPorCategoria');
Route::get('/producto', 'ProductosController@getProducto')->name('verProducto');


//TODO Rutas de administracion
Route::view('/loginAdmin','admin.login')->name('loginAdmin')->middleware('guest'); //? Muestra el form para login

Route::post('loginAdmin','Auth\LoginController@login')->name('login');
Route::post('logout','Auth\LoginController@logout')->name('logout');

Route::get('/admin','AdminController@getPanel')->name('admin')->middleware('auth'); //? Muestra el panel de administracion
  //* Rutas de administracion para productos
  Route::post('/admin/SubCat','AdminController@getSubCategorias')->name('subCat')->middleware('auth');
  Route::post('/regProducto','AdminController@storeProducto')->name('regProducto')->middleware('auth');

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