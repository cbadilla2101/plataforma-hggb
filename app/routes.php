<?php

require_once __DIR__ . '/Helpers/Route.php';
require_once __DIR__ . '/Controllers/HomeController.php';
require_once __DIR__ . '/Controllers/AuthController.php';
require_once __DIR__ . '/Controllers/UsuarioController.php';

Route::get('/', HomeController::class, 'index');

Route::get('/iniciar-sesion', AuthController::class, 'mostrarIniciarSesion');
Route::post('/iniciar-sesion', AuthController::class, 'iniciarSesion');
Route::get('/cerrar-sesion', AuthController::class, 'cerrarSesion');
Route::get('/registro', AuthController::class, 'mostrarRegistro');
Route::post('/registro', AuthController::class, 'registro');

Route::get('/usuarios', UsuarioController::class, 'index');
Route::get('/usuarios/{id}', UsuarioController::class, 'mostrar');
