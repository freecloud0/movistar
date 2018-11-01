<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquidacion extends Model
{
    public $timestamps = false;
    protected $table = 'ctliqui';
    protected $primarykey = 'ctliqui_id';
    protected $fillable = ['ctliqui_id','ctliqui_sot','ctliqui_fechareg','ctliqui_userliqui','ctliqui_userper'];
}
