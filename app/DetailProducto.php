<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailProducto extends Model
{
    public $timestamps = false;
    protected $table='ctdetpr';
    protected $fillable=['ctdetpr_produc_id','ctdetpr_serie','ctdetpr_undmd_code','ctdetpr_tipro_code',
    'ctdetpr_esta_code','ctdetpr_mac1','ctdetpr_mac2','ctdetpr_mac3','ctdetpr_lote','ctdetpr_sap',
    'ctdetpr_esta_equi','ctdetpr_fecha_reg','ctdetpr_fecha_act','ctdetpr_usuario','ctdetpr_fechaLiqui'];
    
    public function detalleguia()
    {
        return $this->belongsTo('App\DetalleGuia','ctdetpr_produc_id','ctdetgu_produc_id');
    }
    // public function detallesalida()
    // {
    //     return $this->belongsTo('App\DetalleSalida','ctdetpr_produc_id','ctdetsa_roduc_id');
    // }

}
