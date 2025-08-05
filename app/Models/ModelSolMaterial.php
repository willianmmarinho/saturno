<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelSolMaterial extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'sol_material';
    protected $fillable = [
        'data',
        'motivo',
        'prioridade',
        'status',
        'id_setor',
        'id_resp_sol_mt',
        'dt_usu_pres',
        'dt_usu_dir',
        'dt_usu_adm',
        'dt_usu_fin',
        'dt_usu_daf',
        'aut_usu_pres',
        'aut_usu_dir',
        'aut_usu_adm',
        'aut_usu_fin',
        'aut_usu_daf',
        'motivo_recusa',
        'tipo_sol_material',
        'id_resp_mt',
    ];

    public function matProposta()
    {
        return $this->hasMany(ModelMatProposta::class, 'id_sol_mat');
    }
    public function tipoStatus()
    {
        return $this->belongsTo(ModelTipoStatusSolMt::class, 'status');
    }
    public function setor()
    {
        return $this->belongsTo(ModelSetor::class, 'id_setor');
    }
    public function modelPessoa()
    {
        return $this->belongsTo(ModelPessoa::class, 'id_resp_sol_mt');
    }
    public function tipoSolMat()
    {
        return $this->belongsTo(ModelTipoSolMat::class, 'tipo_sol_mat');
    }
    public function modelPessoaResponsavel()
    {
        return $this->belongsTo(ModelPessoa::class, 'id_resp_mt');
    }
}
