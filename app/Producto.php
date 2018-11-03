<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public $timestamps = false;
    protected $table='ctproduc';
    protected $fillable=['ctproduc_catego_id','ctproduc_nombre','ctproduc_desc','ctproduc_fecha_reg','ctproduc_fecha_act','ctproduc_usuario'];
    protected $primaryKey='ctproduc_id';

    // public function categoria()
    // {
    //     return $this->belongsTo('App\Categoria','idCategoria');
    // }
}
