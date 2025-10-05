<?php

namespace App\Dominio;

class MedicamentoDomain {
     private int $id;
     private string $nombre; 
     private float $dosis; 
     private int $cantidad;

    public function __construct(int $id, string $nombre, float $dosis) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->dosis = $dosis;
        $this->cantidad = 0;
    }

    public function getId() : int {
        return $this->id; 
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getDosis(): float {
        return $this->dosis;
    }

    public function getCantidad(): int {
        return $this->cantidad;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function setDosis(float $dosis): void {
        $this->dosis = $dosis;
    }

    public function setCantidad(int $cantidad): void {
        $this->cantidad = $cantidad;
    }
    
}