<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelSalas extends Model
{
    protected $table ='salas';

    protected $connection = 'pgsql2';
}
