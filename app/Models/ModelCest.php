<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCest extends Model
{
    use HasFactory;
    protected $table = 'tipo_cest';

    protected $fillable = [
        'id',
        'ncm_sh',
        'segmento_cest',
        'item',
        'descricao_cest',
        'anexo_xxvii',
    ];

    public $timestamps = false;

}
