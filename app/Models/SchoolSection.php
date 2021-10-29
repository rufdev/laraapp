<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class SchoolSection extends Model
{
    use HasApiTokens;
    //
    protected $fillable = [
        'schoolid','schoollevelid','name', 'code', 'description', 'programname', 'programcode', 'programdescription', 'sin'
    ];
    protected $table = 'schoolsection';

    public function school(){

        return $this->belongsTo('App\School','schoolid','id');
    }

    public function schoollevel(){

        return $this->belongsTo('App\SchoolLevel','schoollevelid','id');
    }
}
