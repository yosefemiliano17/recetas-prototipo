<?php

namespace App\Dominio;

use App\Dominio\MedicamentoDomain; 
use App\Servicios\BaseDeDatos;

class InventarioDomain {
    private int $idSucursal;
    private array $medicamentos; 
    
    public function __construct(int $idSucursal, array $medicamentos = []) {
        $this->idSucursal = $idSucursal;
        $this->medicamentos = $medicamentos;
    }

    public function getIdSucursal(): int {
        return $this->idSucursal;
    }
    public function getMedicamentos(): array {
        return $this->medicamentos;
    }
    public function setMedicamentos(array $medicamentos): void {
        $this->medicamentos = $medicamentos;
    }
    public function obtenerExistencias(MedicamentoDomain $medicamento): int {
        $medId = $medicamento->getId();
        if(isset($this->medicamentos[$medId]) === false) {
            return 0; 
        }
        return $this->medicamentos[$medId]['stockActual'];
    }

    public function restarExistencias(MedicamentoDomain $medicamento, int $cantidad): void {
        BaseDeDatos::getInstance()->updateExistencias($this->idSucursal, $medicamento, $cantidad);
    }
}