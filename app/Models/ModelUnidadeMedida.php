<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelUnidadeMedida extends Model
{
    protected $table = 'tipo_unidade_medida';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'sigla',
        'ativo',
        'tipo',
    ];
}
