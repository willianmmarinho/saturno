<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelEmbalagem extends Model
{
    protected $table = 'embalagem';

    public $timestamps = false;

    protected $fillable = [
        'id_item_catalogo',
        'id_un_med_n1',
        'qtde_n1',
        'id_un_med_n2',
        'qtde_n2',
        'id_un_med_n3',
        'qtde_n3',
        'id_un_med_n4',
        'qtde_n4',
        'peso',
        'altura',
        'largura',
        'comprimento',
        'id_tp_material',
        'ativo',
    ];

    public function itemMaterial()
    {
        return $this->belongsTo(ModelItemCatalogoMaterial::class, 'id_item_catalogo');
    }
    public function unidadeMedida()
    {
        return $this->belongsTo(ModelUnidadeMedida::class, 'id_un_med_n1');
    }
    public function unidadeMedida2()
    {
        return $this->belongsTo(ModelUnidadeMedida::class, 'id_un_med_n2');
    }
    public function unidadeMedida3()
    {
        return $this->belongsTo(ModelUnidadeMedida::class, 'id_un_med_n3');
    }
    public function unidadeMedida4()
    {
        return $this->belongsTo(ModelUnidadeMedida::class, 'id_un_med_n4');
    }
}
