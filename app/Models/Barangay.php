<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Barangay extends Model
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
    protected $table = 'barangay';

    public function municipality(){

        return $this->hasOne('App\Municipality','parentid','id');

    }
}
