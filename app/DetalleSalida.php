<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleSalida extends Model
{
    public $timestamps = false;
    protected $table='ctdetsa';
    protected $fillable=['ctdetsa_salid_nro','ctdetsa_roduc_id','ctdetsa_serie','ctdetsa_undmd_code',
    'ctdetsa_tipro_code','ctdetsa_esta_code','ctdetsa_mac1','ctdetsa_mac2','ctdetsa_mac3',
    'ctdetsa_lote','ctdetsa_sap','ctdetsa_cantidad','ctdetsa_fecha_reg','ctdetsa_fecha_act',
    'ctdetsa_detgu_fecha_reg','ctdetsa_observacion','ctdetsa_traspaso','ctdetsa_colab_id','ctdetsa_cantidad_traspaso',
    'ctdetsa_fecha_traspaso','ctdetsa_usuario','ctdetsa_indice','ctdetsa_sot','ctdetsa_undmdDescri',
    'ctdetsa_undmdDescri'];   
    public function detalleProductoS()
    {
        return $this->hasmany('App\DetailProducto','ctdetsa_roduc_id','ctdetpr_produc_id');
    }
}
