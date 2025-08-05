<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelCfop extends Model
{
    protected $table = 'tipo_cfop';

    protected $fillable = [
        'cfop',
        'descricao',
        'observacao',
        'tipooperacao',
        'identificadordestinooperacao',
    ];

    public $timestamps = false;
}
