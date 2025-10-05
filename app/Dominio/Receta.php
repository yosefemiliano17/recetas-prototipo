<?php

namespace App\Dominio;

class Receta {
    
    private array $medicamentos;

    public function __construct() {
        $this->medicamentos = [];
    }

    public function agregarMedicamento(Medicamento $medicamento): void {
        $this->medicamentos[] = $medicamento;
    }

    public function getMedicamentos(): array {
        return $this->medicamentos;
    }

}