<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class SurveyPeriod extends Model
{
    use HasApiTokens;
    //
    protected $fillable = [
        'state', 'code', 'name', 'description'
    ];
    protected $table = 'surveyperiod';

}
