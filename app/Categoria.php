<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public $timestamps = false;
    protected $table='ctcatego';
    protected $fillable=['ctcatego_desc','ctcatego_fecha_reg','ctcatego_fecha_act','ctcatego_usuario'];
    protected $primaryKey='ctcatego_id';

    // public function productos()
    // {
    //     return $this->hasMany('App\Producto','idCategoria','idCategoria');
    // }
}
