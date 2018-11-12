<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    
    public $timestamps = false;
    protected $table='ctprove';
    protected $fillable=['ctprove_razon_social','ctprove_nro_ruc','ctprove_direccion',
    'ctprove_email','ctprove_telefono','ctprove_fecha_reg','ctprove_fecha_act',
    'ctprove_usuario','estado'];
    protected $primaryKey='ctprove_code';

}
