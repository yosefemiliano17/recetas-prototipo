<?php

namespace App\Dominio;

use App\Dominio\RecetaDomain;
use App\Dominio\InventarioDomain;
use App\Servicios\BaseDeDatos;

class SucursalDomain {
    private int $id;
    private string $nombre;
    private InventarioDomain $inventario;

    public function __construct(int $idSucursal, string $nombre)
    {
        $this->id = $idSucursal;
        $this->nombre = $nombre;
        $this->inventario = BaseDeDatos::getInstance()->getInventario($this->id); 
    }

    public function getInventario() : InventarioDomain {
        return $this->inventario; 
    }
    public function getId() : int {
        return $this->id; 
    }
    public function getNombre() : string {
        return $this->nombre;
    }
    

}