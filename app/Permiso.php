<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    public $timestamps = false;
    protected $table='permiso';
    protected $fillable=['idPermiso','categorias','equipos','UserID'];
    protected $primaryKey='idPermiso';

    public function usuarios()
    {
        return $this->hasMany('App\User','UserID','ctusuar_code');
    }
}
