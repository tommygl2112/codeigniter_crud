<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Libro;

class Libros extends Controller
{

    public function index()
    {

        $libro = new Libro();
        $datos['libros'] = $libro->orderBy('id', 'ASC')->findAll();

        $datos['cabecera'] = view('templates/cabecera');
        $datos['pie'] = view('templates/piepagina');

        return view('libros/listar', $datos);
    }

    public function crear()
    {
        $datos['cabecera'] = view('templates/cabecera');
        $datos['pie'] = view('templates/piepagina');

        return view('libros/crear', $datos);
    }

    public function guardar()
    {
        $libro = new Libro();

        $validacion = $this->validate([
            'name' => 'required|min_length[3]',
            'image' => [
                'uploaded[imagen]',
                'mime_in[imagen,image/jpg,image/jpeg,image/png]',
                'max_size[imagen,1024]',
            ]
        ]);

        if (!$validacion) {
            $session = session();
            $session->setFlashdata('mensaje', 'Revise la informacion');

            return redirect()->back()->withInput();

            // return $this->response->redirect(site_url('/listar'));
        }

        $request = service('request');

        if ($imagen = $request->getFile('imagen')) {
            $nuevoNombre = $imagen->getRandomName();
            $imagen->move('../public/uploads', $nuevoNombre);
            $datos = [
                'nombre' => $request->getVar('nombre'),
                'imagen' =>  $nuevoNombre
            ];
            $libro->insert($datos);
        }
        echo "Ingresado a la bd";
    }

    public function borrar($id = null)
    {
        $libro = new Libro();
        $datosLibro = $libro->where('id', $id)->first();

        $ruta = ('../public/uploads/' . $datosLibro['imagen']);
        unlink($ruta);

        $libro->where('id', $id)->delete($id);

        return $this->response->redirect(site_url('/listar'));
    }

    public function editar($id = null)
    {
        print_r($id);
        $libro = new Libro();
        $datos['libro'] = $libro->where('id', $id)->first();

        $datos['cabecera'] = view('templates/cabecera');
        $datos['pie'] = view('templates/piepagina');

        return view('libros/editar', $datos);
    }

    public function actualizar()
    {
        $libro = new Libro();
        $request = service('request');
        $datos = [
            'nombre' => $request->getVar('nombre')
        ];
        $id = $request->getVar('id');

        $libro->update($id, $datos);

        $validacion = $this->validate([
            'name' => 'required|min_length[3]',
        ]);

        if (!$validacion) {
            $session = session();
            $session->setFlashdata('mensaje', 'Revise la informacion');

            return redirect()->back()->withInput();

            // return $this->response->redirect(site_url('/listar'));
        }

        $validacion = $this->validate([
            'image' => [
                'uploaded[imagen]',
                'mime_in[imagen,image/jpg,image/jpeg,image/png]',
                'max_size[imagen,1024]',
            ]
        ]);

        if ($validacion) {
            if ($imagen = $request->getFile('imagen')) {
                $datosLibro = $libro->where('id', $id)->first();
                $ruta = ('../public/uploads/' . $datosLibro['imagen']);
                unlink($ruta);
                $nuevoNombre = $imagen->getRandomName();
                $imagen->move('../public/uploads', $nuevoNombre);
                $datos = [
                    'imagen' =>  $nuevoNombre
                ];
                $libro->update($id, $datos);
            }
        }

        return $this->response->redirect(site_url('/listar'));
    }
}
