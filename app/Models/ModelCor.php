<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelCor extends Model
{
    protected $table = 'cor';

    public $timestamps = false;

    public function tipoCategoriaMt()
    {
        return $this->hasMany(ModelTipoCategoriaMt::class, 'id_categoria_material');
    }
}
