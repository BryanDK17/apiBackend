<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\studentController;
use App\Http\Controllers\registroController;
use App\Http\Controllers\usuarioController;


Route::get('/students', [studentController::class, 'index']);
Route::get('/students/{id}', [studentController::class, 'show']);
Route::post('/students', [studentController::class, 'store']);
Route::put('/students/{id}', [studentController::class, 'update']);
Route::patch('/students/{id}', [studentController::class, 'updatePartial']);
Route::delete('/students/{id}', [studentController::class, 'destroy']);


Route::get('/registro', [registroController::class, 'index']);
Route::post('/registro', [registroController::class, 'store']);


Route::post('/login', [usuarioController::class, 'login']);

Route::get('/usuario', [usuarioController::class, 'index']);
Route::get('/usuario/{id}', [usuarioController::class, 'show']);
Route::post('/usuario', [usuarioController::class, 'store']);
Route::put('/usuario/{id}', [usuarioController::class, 'update']);
Route::patch('/usuario/{id}', [usuarioController::class, 'updatePartial']);
Route::delete('/usuario/{id}', [usuarioController::class, 'destroy']);

Route::middleware('auth:api')->get('/usuario-id', [UsuarioController::class, 'obtenerIdUsuario']);


