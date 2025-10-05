<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicamento extends Model
{
    use HasFactory;

    protected $table = 'medicamentos';
    protected $primaryKey = 'idMedicamento';

    public $incrementing = false;

    protected $fillable = [
        'idMedicamento',
        'nombre',
        'gramaje'
    ];

    public $timestamps = false;

}
