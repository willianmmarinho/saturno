<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelDeposito extends Model
{
    protected $table = 'deposito';
    public $timestamps = false;
    protected $fillable = [
        'nome',
        'sigla',
        'id_tp_deposito',
        'ativo',
        'id_sala',
        'capacidade_volume',
        'comprimento',
        'largura',
        'altura',
        'altura_porta',
        'largura_porta',
    ];

    public function tipoDeposito()
    {
        return $this->belongsTo(ModelTipoDeposito::class, 'id_tp_deposito');
    }

    public function sala()
    {
        return $this->belongsTo(ModelSala::class, 'id_sala');
    }
    public function depositoOrigemLocalizacaoCadastroInicial(){
        return $this->hasMany(ModelLocalizacaoCadastroInicial::class, 'id_deposito_origem');
    }
    public function depositoDestinoLocalizacaoCadastroInicial(){
        return $this->hasMany(ModelLocalizacaoCadastroInicial::class, 'id_deposito_destino');
    }
    public function relacaoDepositoSetor()
    {
        return $this->hasMany(ModelRelDepositoSetor::class, 'id_deposito');
    }
    // public function relacaoDepositoSetorSetor()
    // {
    //     return $this->hasManyThrough(ModelSetor::class, ModelRelDepositoSetor::class, 'id_deposito', 'id_setor');
    // }
    // public function relacaoDepositoSetorSetorAtivo()
    // {
    //     return $this->hasManyThrough(ModelSetor::class, ModelRelDepositoSetor::class, 'id_deposito', 'id_setor')
    //         ->where('ativo', true);
    // }

}
