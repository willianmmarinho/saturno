<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelLocalizacaoCadastroInicial extends Model
{
    public $timestamps = false;
    protected $table = 'localizacao_cadastro_inicial';
    protected $fillable = [
        'id_cadastro_inicial',
        'id_remetente',
        'id_destinatario',
        'id_deposito_origem',
        'id_deposito_destino',
        'data'
    ];

    public function cadastroInicial()
    {
        return $this->belongsTo(ModelCadastroInicial::class, 'id_cadastro_inicial');
    }

    public function remetente()
    {
        return $this->belongsTo(ModelUsuario::class, 'id_remetente');
    }
    public function destinatario(){
        return $this->belongsTo(ModelUsuario::class, 'id_destinatario');
    }
    public function depositoOrigem(){
        return $this->belongsTo(ModelDeposito::class, 'id_deposito_origem');
    }

}
