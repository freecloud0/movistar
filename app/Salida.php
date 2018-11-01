<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    public $timestamps = false;
    protected $table='ctsalid';
    protected $fillable=['ctsalid_colab_id','ctsalid_sot_id','ctsalid_fecha_reg','ctsalid_fecha_act',
    'ctsalid_usuario','ctsalid_numguiatecnico'];
    protected $primaryKey='ctsalid_nro';

}
