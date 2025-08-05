<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelCsosnIcms extends Model
{
    protected $table = 'tipo_csosn_icms';

    protected $fillable = [
        'id',
        'nm_icms',
    ];

    public $timestamps = false;
}
