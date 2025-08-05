<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelMatProposta extends Model
{
    public $timestamps = false;

    protected $table = 'mat_proposta';

    protected $fillable = [
        'id_cat_material',
        'id_marca',
        'id_tamanho',
        'id_cor',
        'id_fase_etaria',
        'id_tp_sexo',
        'id_embalagem',
        'id_item_catalogo',
        'id_sol_mat',
        'quantidade',
        'dt_cadastro',
        'valor1',
        'valor2',
        'valor3',
        'observacao',
        'adquirido',
        'dt_validade',
        'componente',
        'modelo',
        'num_serie',
        'chassi',
        'placa',
        'renavam',
        'dt_fab',
        'dt_fab_modelo',
        'id_tipo_material',
        'avariado',
        'aplicacao',
        'componente',
    ];

    public function tipoCategoria()
    {
        return $this->belongsTo(ModelTipoCategoriaMt::class, 'id_cat_material');
    }
    public function tipoMarca()
    {
        return $this->belongsTo(ModelMarca::class, 'id_marca');
    }
    public function tipoTamanho()
    {
        return $this->belongsTo(ModelTamanho::class, 'id_tamanho');
    }
    public function tipoCor()
    {
        return $this->belongsTo(ModelCor::class, 'id_cor');
    }
    public function tipoFaseEtaria()
    {
        return $this->belongsTo(ModelFaseEtaria::class, 'id_fase_etaria');
    }
    public function tipoSexo()
    {
        return $this->belongsTo(ModelSexo::class, 'id_tp_sexo');
    }
    public function tipoUnidadeMedida()
    {
        return $this->belongsTo(ModelUnidadeMedida::class, 'id_embalagem');
    }
    public function tipoItemCatalogoMaterial()
    {
        return $this->belongsTo(ModelItemCatalogoMaterial::class, 'id_item_catalogo');
    }
    public function solMaterial()
    {
        return $this->belongsTo(ModelSolMaterial::class, 'id_sol_mat');
    }
    public function documentoMaterial()
    {
        return $this->hasMany(ModelDocumento::class, 'mat_proposta');
    }
    public function TipoMaterial()
    {
        return $this->belongsTo(ModelTipoMaterial::class, 'id_tipo_material');
    }
    public function Embalagem()
    {
        return $this->belongsTo(ModelEmbalagem::class, 'id_embalagem');
    }
}
