<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Role extends Model
{
    use HasFactory,HasApiTokens;

    protected $fillable = [
        'name', 'code', 'description'
    ];
    protected $table = 'roles';

    public function users(){

        return $this->hasMany('App\Models\User');

    }
}
