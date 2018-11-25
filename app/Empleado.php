<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    public $timestamps = false;
    protected $table='ctcolab';
    protected $fillable=['ctcolab_ap_paterno','ctcolab_ap_materno','ctcolab_nombres','ctcolab_dni','ctcolab_direccion'
                        ,'ctcolab_telefono','ctcolab_celular','ctcolab_email',
                        'ctcolab_fecha_reg','ctcolab_fecha_act','ctcolab_usuario'];
    protected $primaryKey='ctcolab_id';

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
