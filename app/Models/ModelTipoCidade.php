<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelTipoCidade extends Model
{
    use HasFactory;

    protected $table = 'tp_cidade';

    protected $connection = 'pgsql2';

    public function ModelTipoUf()
    {
        return $this->belongsTo(ModelTipoUf::class, 'id_uf');
    }
}
