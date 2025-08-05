<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelPessoa extends Model
{
    protected $table ='pessoas';

    protected $connection = 'pgsql2';
    protected $fillable = [
        'nome_completo',
        'idt',
        'uf_idt',
        'orgao_expedidor',
        'dt_emissao_idt',
        'dt_nascimento',
        'uf_natural',
        'naturalidade',
        'nacionalidade',
        'sexo',
        'email',
        'ddd',
        'celular',
        'motivo_status',
        'status',
        'cpf',
        'caminho_foto_pessoa',
        'nome_resumido',
        'cel_estrangeiro',
        'tel_fixo',
    ];
      public function funcionario()
    {
        return $this->hasOne(ModelFuncionario::class, 'id_pessoa');
    }

    public function usuario()
    {
        return $this->hasOne(ModelUsuario::class, 'id_pessoa');
    }

}
