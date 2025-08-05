<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelFaseEtaria extends Model
{
    protected $table = 'fase_etaria';

    public $timestamps = false;

    public function tipoCategoriaMt()
    {
        return $this->hasMany(ModelMatProposta::class, 'id_categoria_material');
    }
}
