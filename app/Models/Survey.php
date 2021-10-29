<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Survey extends Model
{
    use HasApiTokens;
    //
    protected $fillable = [
        'sectionid', 'totalmale', 'totalfemale', 'surveyperiod'
    ];
    protected $table = 'survey';

    public function schoolsection(){

        return $this->belongsTo('App\SchoolSection','sectionid','id');

    }

    public function surveyperiod(){
        return $this->belongsTo('App\SurveyPeriod','surveyperiod','id');
    }

}
