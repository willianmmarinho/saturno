<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelOrigemIcms extends Model
{
    protected $table = 'tipo_origem_icms';

    protected $fillable = [
        'id',
        'tipo',
        'descricao',
    ];

    public $timestamps = false;}
