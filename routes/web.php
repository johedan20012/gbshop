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

Route::get('/catalogo', 'ProductosController@getCatalogoPorCategoria')->name('catalogo');


//Route::get('/productos', 'ProductosController@getProductos')->name('produc');

Route::post('/vGxWbRowQT', 'ProductosController@getProductosPorCategoria')->name('productosPorCategoria');


Route::get('/producto', 'ProductosController@getProducto')->name('verProducto');
//Route::get('/verProducto/{id}', 'ProductosController@getProducto')->name('verProducto');
