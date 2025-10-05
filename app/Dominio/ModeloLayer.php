<?php

namespace App\Dominio;
use App\Servicios\BaseDeDatos;
use Illuminate\Database\Eloquent\Collection;

class ModeloLayer {
    private BaseDeDatos $bd; 
    
    public function __construct() {
        $this->bd = BaseDeDatos::getInstance();
    }

    public function surtirReceta(RecetaDomain $receta, SucursalDomain $sucursal) : void {
        $this->bd->beginTransaction(); 
        try {
            foreach ($receta->getMedicamentos() as $medicamento) {
                $medId = $medicamento->getId();   
                $cantidad = $medicamento->getCantidad(); 
                
                if($sucursal->getInventario()->obtenerExistencias($medicamento) < $cantidad) {
                    throw new \Exception("No hay suficiente stock para el medicamento ID: $medId");
                }   
                $sucursal->getInventario()->restarExistencias($medicamento, $cantidad);      
            }
        }catch(\Exception $e) {
            $this->bd->rollbackTransaction();
            throw $e; 
        }
    }

    public function obtenerTodasLasSucursales() : array {
        return $this->bd->obtenerTodasLasSucursales();
    }

    public function obtenerTodosLosMedicamentos() : array {
        return $this->bd->obtenerTodosLosMedicamentos();
    }

    public function obtenerInventarioSucursal(int $idSucursal) : ?InventarioDomain {
        return $this->bd->getInventario($idSucursal);
    }
}

