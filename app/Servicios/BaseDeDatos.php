<?php

namespace App\Servicios;

use App\Dominio\SucursalDomain;
use App\Models\Inventario; 
use App\Models\Medicamento; 
use App\Models\Sucursal; 
use App\Dominio\InventarioDomain;
use App\Dominio\MedicamentoDomain;

use Illuminate\Support\Facades\DB;

class BaseDeDatos {

    private static ?BaseDeDatos $instance = null;
    private function __construct() {}
    // Evita clonación
    private function __clone() {}
    // Evita unserialización
    public function __wakeup() {
        throw new \Exception("Cannot unserialize singleton");
    }
    public static function getInstance(): BaseDeDatos {
        if (self::$instance === null) {
            self::$instance = new BaseDeDatos();
        }
        return self::$instance;
    }
    public function obtenerTodasLasSucursales(): array {
        $sucursales = Sucursal::all();
        $sucursalesDominio = [];
        
        foreach ($sucursales as $sucursal) {
            $sucursalesDominio[] = new SucursalDomain(
                $sucursal->idSucursal,
                $sucursal->nombre
            );
        }
        
        return $sucursalesDominio;
    }

    public function obtenerTodosLosMedicamentos(): array {
        $medicamentos = Medicamento::all();
        $medicamentosDominio = [];
        
        foreach ($medicamentos as $medicamento) {
            $medicamentosDominio[] = new MedicamentoDomain(
                $medicamento->nombre,
                $medicamento->gramaje
            );
        }

        return $medicamentosDominio;
    }


    public function getInventario(int $sucursalId): InventarioDomain
    {
        $inventarios = Inventario::where('idSucursal', $sucursalId)->get();
        $inventarioArray = [];
        foreach ($inventarios as $inventario) {
            $inventarioArray[$inventario->idMedicamento] = [
                'stockActual' => $inventario->stockActual,
                'stockMinimo' => $inventario->stockMinimo,
                'stockMaximo' => $inventario->stockMaximo,
            ];
        }

        return new InventarioDomain($sucursalId, $inventarioArray);
    }

    public function beginTransaction(): void {
        DB::beginTransaction();
    }

    public function commitTransaction(): void {
        DB::commit();
    }

    public function rollbackTransaction(): void {
        DB::rollBack();
    }

}