<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelUsuario extends Model
{
	protected $table = 'usuario';
    protected $fillable = [
        'id_pessoa',
        'ativo',
        'data_criacao',
        'hash_senha',
        'data_ativacao',
        'bloqueado',
        'token',
        'data_hora_token',
    ];

    public function pessoa()
    {
        return $this->belongsTo(ModelPessoa::class, 'id_pessoa');
    }
}
