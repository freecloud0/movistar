<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleGuia extends Model
{
    public $timestamps = false;
    protected $table='ctdetgu';
    protected $fillable=['ctdetgu_nro','ctdetgu_serie',
    'ctdetgu_prove_code','ctdetgu_produc_id','ctdetgu_code',
    'ctdetgu_desc','ctdetgu_cantidad','ctdetgu_undmd_code',
    'ctdetgu_fecha_reg','ctdetgu_fecha_act','ctdetgu_usuario',
    'ctdetgu_indice','ctdetgu_serieProduc'];
    public function detalleProducto()
    {
        return $this->hasmany('App\DetailProducto','ctdetgu_produc_id','ctdetpr_produc_id');
    }
    public function unidadesMedida()
    {
        return $this->hasmany('App\UnidadMedida','ctdetgu_undmd_code','ctundmd_code');
    }

}
