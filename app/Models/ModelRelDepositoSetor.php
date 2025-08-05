<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelRelDepositoSetor extends Model
{
    protected $table = 'rel_deposito_setor';
    public $timestamps = false;
    protected $fillable = [
        'id_deposito',
        'id_setor',
        'dt_inicio',
        'dt_fim',
    ];
    public function Deposito()
    {
        return $this->belongsTo(ModelDeposito::class, 'id_deposito');
    }
    public function Setor()
    {
        return $this->belongsTo(ModelSetor::class, 'id_setor');
    }
}
