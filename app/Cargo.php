<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    public $timestamps = false;
    protected $table='ctcargo';
    protected $fillable=['ctcargo_nombre','ctcargo_nombre','ctcargo_desc','ctcargo_fecha_reg'
    ,'ctcargo_fecha_act','ctcargo_usuario'];
    protected $primaryKey='ctcargo_code';

    public function users()
    {
        return $this->hasMany('App\User','ctusuar_cargo_code','ctcargo_code');
    }
}
