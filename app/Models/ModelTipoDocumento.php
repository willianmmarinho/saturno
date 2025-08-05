<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelTipoDocumento extends Model
{
    use HasFactory;

    protected $table = 'tipo_documento';
    protected $fillable = [
        'descricao',
        'sigla'
    ];
    public $timestamps = false;

    public function documentos()
    {
        return $this->hasMany(ModelDocumento::class, 'id_tp_doc');
    }
}
