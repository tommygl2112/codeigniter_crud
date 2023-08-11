<?php

namespace App\Controllers;

use App\Models\Libro;

class Home extends BaseController
{
    public function index(): string
    {
        $datos['cabecera'] = view('templates/cabecera');
        $datos['pie'] = view('templates/piepagina');
        $libro = new Libro();
        $datos['libros'] = $libro->orderBy('id', 'ASC')->findAll();

        return view('/libros/listar', $datos);
    }
}
