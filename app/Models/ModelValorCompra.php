<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelValorCompra extends Model
{
    public $timestamps = false;
    protected $table = 'valor_autorizacao_compra';
    protected $fillable = [
        'valor',
        'tipo_sol',
        'tipo_compra',
        'dt_inicio',
        'dt_fim',
        'id_funcionario'
    ];
}
