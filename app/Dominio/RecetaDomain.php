<?php

namespace App\Dominio;

use App\Dominio\MedicamentoDomain; 

class RecetaDomain {
    
    private array $medicamentos;

    public function __construct() {
        $this->medicamentos = [];
    }

    public function agregarMedicamento(MedicamentoDomain $medicamento): void {
        $this->medicamentos[] = $medicamento;
    }

    public function getMedicamentos(): array {
        return $this->medicamentos;
    }

}