<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelTipoMovimento extends Model
{
        public $timestamps = false;
    protected $table = 'tipo_movimento';

    protected $fillable = [
        'nome'
    ];

    public function movimentacao_fisica()
    {
        return $this->hasMany(ModelMovimentacaoFisica::class, 'id_tp_movimento');
    }
}
