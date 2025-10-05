<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 

class Inventario extends Model {

    use HasFactory; 

    protected $table = 'inventario'; 
    public $incrementing = false; 

    protected $fillable = [
        'idInventario',
        'idSucursal',
        'idMedicamento',
        'stockActual',
        'stockMinimo',
        'stockMaximo'
    ]; 

}
