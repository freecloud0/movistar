<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class ProductoMaster extends Model
{
    public $timestamps = false;
    protected $table='ctproduc';
    protected $fillable=['ctproduc_catego_id','ctproduc_nombre','ctproduc_desc',
    'ctproduc_fecha_reg','ctproduc_fecha_act','ctproduc_usuario','estado','sap',
    'ctproduct_stock','ctproduc_undMed','ctproduc_tipro_code','ctproduct_stock_max',
    'ctproduc_stock_uso'];
    protected $primaryKey='ctproduc_id';

    public function salidasProductos()
    {
        return $this->hasMany('App\DetalleSalida','ctdetsa_roduc_id','ctproduc_id');
    }
}
