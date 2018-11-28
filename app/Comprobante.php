<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    public $timestamps = false;
    protected $table='ctgurem';
    protected $fillable=['ctgurem_fecha_emision','ctgurem_fecha_llegada',
                        'ctgurem_fecha_registro','ctgurem_fecha_salida','ctgurem_lugar_salida',
                        'ctgurem_transportista','ctgurem_placa','ctgurem_ruc','ctgurem_chofer',
                        'ctgurem_serie','ctgurem_prove_code'];
    protected $primaryKey='ctgurem_nro';
        
}
