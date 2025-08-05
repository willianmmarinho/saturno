<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelTamanho extends Model
{
    protected $table = 'tamanho';

    public $timestamps = false;

    public function tipoCategoriaMt()
    {
        return $this->hasMany(ModelTipoCategoriaMt::class, 'id_categoria_material');
    }
}
