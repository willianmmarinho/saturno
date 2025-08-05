<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelTipoClasseSv extends Model
{
    use HasFactory;

    protected $table = 'tipo_classe_sv';
    public $timestamps = false;

    public function catalogoServico()
    {
        return $this->hasMany(ModelCatalogoServico::class, 'id_cl_sv');
    }
    public function SolServico()
    {
        return $this->hasMany( ModelSolServico::class,'id_classe_sv');
    }

    protected $fillable = [
        'descricao',
        'sigla',
        'situacao'
    ];
}
