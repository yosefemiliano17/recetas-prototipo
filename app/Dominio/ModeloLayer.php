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
            $cantidad = $medicamento->getCantidad(); 
            $nombre = $medicamento->getNombre();
            $stockActual = $sucursal->getInventario()->obtenerExistencias($medicamento);
            if ($stockActual < $cantidad) {
                throw new \Exception("No hay suficiente stock para el medicamento: $nombre");
            }

            $sucursal->getInventario()->restarExistencias($medicamento, $cantidad);
        }
        
        
        $this->bd->commitTransaction();
        //regresar mensaje de exito a la vista (No olvidar )
    } catch(\Exception $e) {
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

    public function obtenerMedicamentoPorId(int $idMedicamento): MedicamentoDomain {
        return $this->bd->obtenerMedicamentoPorId($idMedicamento); 
    }

    public function obtenerSucursalPorId(int $idSucursal) : ?SucursalDomain {
       return $this->bd->obtenerSucursal($idSucursal);
    }
}

