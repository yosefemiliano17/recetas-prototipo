<?php

namespace App\Dominio;

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
    public function obtenerExistencias($medicamento): int {
        $medId = $medicamento->getId();
        return $this->medicamentos[$medId]['stockActual'] ?? 0;
    }

    //checar
    public function restarExistencias($medicamento, int $cantidad): void {
        $medId = $medicamento->getId();
        if (isset($this->medicamentos[$medId])) {
            $this->medicamentos[$medId]['stockActual'] -= $cantidad;
            if ($this->medicamentos[$medId]['stockActual'] < 0) {
                $this->medicamentos[$medId]['stockActual'] = 0; 
            }
        } else {
            throw new Exception("El medicamento ID: $medId no existe en el inventario.");
        }
    }
}