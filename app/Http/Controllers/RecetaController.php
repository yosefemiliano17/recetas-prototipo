<?php

namespace App\Http\Controllers;

use App\Dominio\ModeloLayer;
use Illuminate\Http\Request;
use App\Dominio\SucursalDomain;
use App\Dominio\RecetaDomain;


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
        $validated = $request->validate([
            'sucursal_id' => 'required|integer|exists:sucursales,idSucursal',
            'medicamentos' => 'required|array|min:1',
            'medicamentos.*.id' => 'required|integer|exists:medicamentos,idMedicamento',
            'medicamentos.*.cantidad' => 'required|integer|min:1',
        ], [
            'sucursal_id.required' => 'Debes seleccionar una sucursal.',
            'medicamentos.*.id.required' => 'Debes seleccionar un medicamento en todas las filas.',
            'medicamentos.*.cantidad.min' => 'La cantidad de cada medicamento debe ser al menos 1.',
        ]);

       
        try {
            $sucursalDomain = $this->modelo->obtenerSucursalPorId($validated['sucursal_id']);
            $recetaDomain = new RecetaDomain();

            foreach ($validated['medicamentos'] as $medData) {
                $medicamentoDomain = $this->modelo->obtenerMedicamentoPorId($medData['id']);
                $medicamentoDomain->setCantidad($medData['cantidad']);
                $recetaDomain->agregarMedicamento($medicamentoDomain);
            }

           
            $this->modelo->surtirReceta($recetaDomain, $sucursalDomain);

            return redirect()->route('recetas.create')->with('success', 'Receta generada y surtida exitosamente.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
