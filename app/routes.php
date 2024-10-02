<?php

require_once __DIR__ . '/Helpers/Route.php';
require_once __DIR__ . '/Controllers/HomeController.php';

Route::get('/', HomeController::class, 'index');
