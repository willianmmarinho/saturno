<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCatalogoServico extends Model
{
    use HasFactory;

    protected $table = 'catalogo_servico';

    public function tipoClasseSv()
    {
        return $this->belongsTo(ModelTipoClasseSv::class, 'id_cl_sv');
    }
    public function SolServico()
    {
        return $this->hasMany( ModelSolServico::class,'id_tp_sv');
    }

    protected $fillable = [
        'id_cl_sv',
        'descricao',
        'situacao'
    ];
    public $timestamps = false;
}
