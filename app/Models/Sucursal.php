<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sucursal extends Model
{
    use HasFactory;

    protected $table = 'sucursales';
    protected $primaryKey = 'idSucursal';
    public $incrementing = false;

    protected $fillable = [
        'idSucursal',
        'nombre'
    ];

    public $timestamps = false;

}
