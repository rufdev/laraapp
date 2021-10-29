<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Municipality extends Model
{
    use HasApiTokens;
    //
    protected $casts = [
        'id'            => 'string',
    ];
    protected $fillable = [
                'id',
                'state',
                'pin',
                'name',
                'parentid',
    ];
    protected $table = 'municipality';

    public function barangays(){

        return $this->hasMany('App\Barangay','parentid','id');

    }

    public function province(){

        return $this->hasOne('App\Province','id','parentid');

    }
}
