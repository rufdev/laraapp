<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Province extends Model
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
                'name'
    ];
    protected $table = 'province';

    public function municipalities(){

        return $this->hasMany('App\Municipality','parentid','id')->with('barangays');

    }
}
