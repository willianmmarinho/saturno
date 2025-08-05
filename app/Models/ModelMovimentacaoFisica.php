<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ModelTipoMovimento;

class ModelMovimentacaoFisica extends Model
{
    public $timestamps = false;
    protected $table = 'movimentacao_fisica';
    protected $fillable = [
        'id_item_material',
        'id_cadastro_inicial',
        'id_remetente',
        'id_destinatario',
        'data',
        'id_deposito_origem',
        'id_deposito_destino',
        'id_tp_movimento',

    ];

    public function cadastro_inicial()
    {
        return $this->belongsTo(ModelCadastroInicial::class, 'id_cadastro_inicial');
    }

    public function remetente()
    {
        return $this->belongsTo(ModelUsuario::class, 'id_remetente');
    }
    public function destinatario()
    {
        return $this->belongsTo(ModelUsuario::class, 'id_destinatario');
    }
    public function deposito_origem()
    {
        return $this->belongsTo(ModelDepositoMaterial::class, 'id_deposito_origem');
    }
    public function deposito_destino()
    {
        return $this->belongsTo(ModelDepositoMaterial::class, 'id_deposito_destino');
    }
    public function tipo_movimento()
    {
        return $this->belongsTo(ModelTipoMovimento::class, 'id_tp_movimento');
    }
}
