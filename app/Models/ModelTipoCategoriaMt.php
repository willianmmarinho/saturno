<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelTipoCategoriaMt extends Model
{
    use HasFactory;
    protected $table = 'tipo_categoria_material';
    public $timestamps = false;
    protected $fillable = [
        'nome',
    ];
}
