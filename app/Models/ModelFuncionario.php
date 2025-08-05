<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelFuncionario extends Model
{
     protected $table = 'funcionarios';
    protected $connection = 'pgsql2';

    protected $fillable = [
        'matricula',
        'ctps',
        'uf_ctps',
        'serie',
        'dt_emissao_ctps',
        'tp_programa',
        'nr_programa',
        'reservista',
        'primeiro_emprego',
        'vale_transporte',
        'id_pessoa',
        'id_dados_bancarios',
        'id_cat_cnh',
        'id_cor_pele',
        'id_tp_sangue',
        'nome_mae',
        'nome_pai',
        'fator_rh',
        'titulo_eleitor',
        'zona_tit',
        'secao_tit',
        'dt_titulo',
    ];
    public function pessoa()
    {
        return $this->belongsTo(ModelPessoa::class, 'id_pessoa');
    }
}
