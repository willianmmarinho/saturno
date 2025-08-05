<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelTipoNaturezaContaContabil extends Model
{
    protected $table = "tipo_natureza_conta_contabil";
    protected $fillable = ["nome"];
    public $timestamps = false;

    public function conta_contabil()
    {
        return $this->hasMany(ModelContaContabil::class, "id_tipo_natureza_conta_contabil", "id");
    }
}

