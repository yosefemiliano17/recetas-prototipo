<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dominio\Sucursal;

class ControladorSucursal extends Controller
{
    private Sucursal $sucursal;

    public function __construct(Sucursal $sucursal) {
        $this->sucursal = $sucursal;
    }

    //nombre a consideracion de cambio
    public function surtirReceta(Request $request) {
        
    }
}