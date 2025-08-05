<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelTipoPais extends Model
{
    use HasFactory;

    protected $table = 'tipo_pais';

    public $timestamps = false;

}
