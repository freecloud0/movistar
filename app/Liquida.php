<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquida extends Model
{
    public $timestamps = false;
    protected $table = 'ctliquid';
    protected $primarykey = 'ctliquid_id';
    protected $fillable = ['ctliquid_id','ctliquid_ordenid','ctliquid_tipoid',
                            'ctliquid_medidaid','ctliquid_cantidad',
                            'ctliquid_serie','ctliquid_userid',
                            'ctliquid_userlogin','ctliquid_fechareg','ctliquid_sap'];

    public function ordenes()
    {
        return $this->belongsToMany('App\Orden');
    }
    public function liquidaMedida()
    {
        return $this->belongsTo('App\UnidadMedida','ctliquid_medidaid','ctundmd_code');
    }
    public function liquidauser()
    {
        return $this->belongsTo('App\User','ctliquid_userid','ctusuar_code');
    }
    public function liquidatipo()
    {
        return $this->belongsTo('App\Tipo','ctliquid_tipoid','cttipro_code');
    }
}
