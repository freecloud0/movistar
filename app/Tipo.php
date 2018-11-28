<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    public $timestamps = false;
    protected $table='cttipro';
    protected $fillable=['cttipro_code','cttipro_desc','cttipro_fecha_reg','cttipro_fecha_act','cttipro_usuario'];
    protected $primaryKey='cttipro_code';

    public function tipo_liquidacion()
    {
        return $this->hasmany('App\Liquida','cttipro_code','ctliquid_tipoid');
    }
}
