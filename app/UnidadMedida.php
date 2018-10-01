<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    public $timestamps = false;
    protected $table='ctundmd';
    protected $fillable=['ctundmd_desc','ctundmd_fecha_reg','ctundmd_fecha_act','ctundmd_usuario','estado'];
    protected $primaryKey='ctundmd_code';
}
