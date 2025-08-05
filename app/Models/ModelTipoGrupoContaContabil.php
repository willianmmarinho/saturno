<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelTipoGrupoContaContabil extends Model
{
    protected $table = "tipo_grupo_conta_contabil";
    protected $fillable = ["nome"];
    public $timestamps = false;
    public function conta_contabil(){
        return $this->hasMany(ModelContaContabil::class,"tipo_grupo_conta_contabil","id",);
    }
}
