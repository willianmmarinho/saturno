<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelNcm extends Model
{
    protected $table = 'tipo_ncm';

    protected $fillable = [
        'id',
        'descricao',
        'dt_ini',
        'dt_fim',
        'num_ato',
        'ano_ato',
        'tipo_ato',
    ];

    public $timestamps = false;
}
