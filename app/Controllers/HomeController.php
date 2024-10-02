<?php

require_once __DIR__ . '/BaseController.php';

class HomeController extends BaseController
{
    /**
     * Muestra la home.
     *
     * @return void
     */
    public function index(): void
    {
        $this->render('Home', ['title' => 'Inicio']);
    }
}
