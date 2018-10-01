<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
    use Notifiable,HasRolesAndAbilities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps=false;
    protected $table='ctusuar';
    protected $primaryKey='ctusuar_code';
    protected $fillable = [
        'ctusuar_usuario', 'ctusuar_colab_id', 'ctusuar_cargo_code','ctusuar_email','password',
        'ctusuar_fecha_reg','ctusuar_fecha_act','ctusuar_usuario_code','estado'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function cargo()
    {
        return $this->belongsTo('App\Cargo','ctusuar_cargo_code');
    }
    public function empleado()
    {
        return $this->belongsTo('App\Empleado','ctcolab_id');
    }

    public function permiso()
    {
        return $this->belongsTo('App\Permiso','ctusuar_code');
    }
}
