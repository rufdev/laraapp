<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class School extends Model
{
    use HasApiTokens;
    //
    protected $fillable = [
        'name', 'code', 'description','municipalityid'
    ];
    protected $table = 'school';

    public function municipality(){

        return $this->belongsTo('App\Municipality','municipalityid','id');

    }

    public function schoolsections(){

        return $this->hasMany('App\SchoolSection','schoolid','id')->with('schoollevel');

    }
}
