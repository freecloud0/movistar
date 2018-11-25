<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    public $timestamps = false;
    protected $table = 'ctorden';
    protected $fillable = ['ctorden_id','ctorden_numorden','ctorden_cliente',
                            'ctorden_direccliente','ctorden_codigo',
                            'ctorden_userID','ctorden_fechareg'];
                            protected $primaryKey='ctorden_id';
    public function orden()
    {
        return $this->belongsTo('App\User','ctorden_userID','ctusuar_code');
    }
    public function liquidaciones()
    {
        return $this->belongsToMany('App\Liquida');
    }
   
}
