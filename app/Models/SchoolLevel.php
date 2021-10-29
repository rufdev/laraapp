<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;


class SchoolLevel extends Model
{
    use HasApiTokens;
    //
    protected $fillable = [
        'name', 'type', 'code', 'description'
    ];
    protected $table = 'schoollevel';

    public function schoolsections(){

        return $this->hasMany('App\SchoolSection');
    }

}
