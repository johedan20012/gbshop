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

Route::get('/','ProductosController@getInicio')->name('inicio');

Route::get('/catalogo', 'ProductosController@getCatalogoPorCategoria')->name('catalogo');


//Route::get('/productos', 'ProductosController@getProductos')->name('produc');

Route::post('/vGxWbRowQT', 'ProductosController@getProductosPorCategoria')->name('productosPorCategoria');
Route::post('/regProducto','ProductosController@store')->name('regProducto')->middleware('auth');
Route::get('/producto', 'ProductosController@getProducto')->name('verProducto');
//Route::get('/verProducto/{id}', 'ProductosController@getProducto')->name('verProducto');

Route::get('/admin/{numPag?}','AdminController@getPanel')->name('admin')->middleware('auth');
Route::post('/admin/SubCat','AdminController@getSubCategorias')->name('subCat')->middleware('auth');
Route::post('/admin/regMarca','AdminController@storeMarca')->name('storeMarca')->middleware('auth');
Route::post('/admin/regCategoria','AdminController@storeCategoria')->name('storeCategoria')->middleware('auth');

Route::view('/loginAdmin','auth.login')->name('loginAdmin')->middleware('guest');

// Authentication Routes...
/*
Route::get('login', [
    'as' => 'login',
    'uses' => 'Auth\LoginController@showLoginForm'
  ]);*/
  Route::post('loginAdmin', [
    'as' => 'login',
    'uses' => 'Auth\LoginController@login'
  ]);
  Route::post('logout', [
    'as' => 'logout',
    'uses' => 'Auth\LoginController@logout'
  ]);