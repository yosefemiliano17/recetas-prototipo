<?php

namespace App\Http\Controllers;

use App\Dominio\ModeloLayer;
use Illuminate\Http\Request;
use App\Dominio\SucursalModel;


class RecetaController extends Controller
{
    private ModeloLayer $modelo; 

    public function __construct()
    {
        $this->modelo = new ModeloLayer();
    }

    public function create()
    {
        $sucursales = $this->modelo->obtenerTodasLasSucursales();
        return view('welcome', ['sucursales' => $sucursales]);
    }
    public function show($id)
    {
        $inventario = $this->modelo->obtenerInventarioSucursal($id);
        if (!$inventario) {
            return redirect()->route('recetas.create')->with('error', 'Sucursal no encontrada.');
        }
        $medicamentosDetalles = $this->modelo->obtenerTodosLosMedicamentos();

        return view('sucursal_detalle', ['sucursal' => $inventario, 'medicamentosDetalles' => $medicamentosDetalles]);
    }


    public function store(Request $request)
    {
        return redirect()->route('recetas.create')->with('success', 'Receta generada exitosamente.');
    }
}