<?php

namespace App\Dominio;

class Medicamento {

    private string $nombre; 
    private float $dosis; 
    
    public function __construct(string $nombre, float $dosis) {
        $this->nombre = $nombre;
        $this->dosis = $dosis;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getDosis(): float {
        return $this->dosis;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function setDosis(float $dosis): void {
        $this->dosis = $dosis;
    }

}