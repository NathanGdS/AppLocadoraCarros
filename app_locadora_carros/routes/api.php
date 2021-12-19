<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('cliente', 'ClienteController');
Route::apiResource('carro', 'CarroController');
Route::get('/carro/findByPlaca/{placa}', 'CarroController@findByPlaca');

Route::apiResource('locacao', 'LocacaoController');

Route::apiResource('marca', 'MarcaController');
Route::get('/marca/findByName/{name}', 'MarcaController@findByName');

Route::apiResource('modelo', 'ModeloController');
Route::get('/modelo/findByName/{name}', 'ModeloController@findByName');
