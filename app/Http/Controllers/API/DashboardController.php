<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Survey;
use App\Models\School;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        //$this->authorize('isAdmin');
    }
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isSupport') || \Gate::allows('isGuest') || \Gate::allows('isTechnical')) {

            // subscriber
            // $dashdata = Subscriber::selectRaw('count(*) as subscribercount')->get()->first();
            // $dashdata->activesubscribers = Subscriber::with(['chatowner'])
            // ->where('state','ACTIVE')
            // ->count();
            $dashdata = (object)[];

            //user count
            $dashdata->usercount = User::count();


            $dashdata->schools = School::all();

            $dashdata->studenttotal = Survey::selectRaw('SUM(survey.`totalmale`) AS totalmale,SUM(survey.`totalfemale`) AS totalfemale')
            ->join('schoolsection', 'schoolsection.id','=', 'survey.sectionid')
            ->join('school', 'school.id','=', 'schoolsection.schoolid')
            ->join('schoollevel', 'schoollevel.id','=', 'schoolsection.schoollevelid')
            ->join('municipality', 'municipality.id','=', 'school.municipalityid')
            ->join('surveyperiod', function($join){
                $join->where('surveyperiod.state','=', 'ACTIVE')
                     ->on('survey.surveyperiodid','=', 'surveyperiod.id');
            })
            ->orderBy('municipality.id')
            ->orderBy('school.name')
            ->orderBy('schoollevel.id')
            ->get();

            // $dashdata->ownedsubscribers = Subscriber::with(['chatowner'])
            // ->whereHas('chatowner', function ($query) {
            //     $query->whereNotNull('owner_id');
            // })->where('state','ACTIVE')
            // ->count();
        }else{
            return response('Unauthorized.', 401);
        }
        return $dashdata;
    }
    public function getschoolchartdata(Request $request){

        if (\Gate::allows('isAdmin') || \Gate::allows('isSupport') || \Gate::allows('isGuest') || \Gate::allows('isTechnical')) {
            $items = Survey::selectRaw('survey.id, school.id AS schoolid,municipality.`name` AS municipality,school.`name` AS schoolname,schoollevel.`name` AS levelname,schoollevel.`type` AS leveltype,survey.`totalmale`,survey.`totalfemale`, survey.`totalfemale` + survey.`totalmale` AS totalstudents')
            ->join('schoolsection', 'schoolsection.id','=', 'survey.sectionid')
            ->join('school', 'school.id','=', 'schoolsection.schoolid')
            ->join('schoollevel', 'schoollevel.id','=', 'schoolsection.schoollevelid')
            ->join('municipality', 'municipality.id','=', 'school.municipalityid')
            ->join('surveyperiod', function($join){
                $join->where('surveyperiod.state','=', 'ACTIVE')
                     ->on('survey.surveyperiodid','=', 'surveyperiod.id');
            })
            ->where('school.id','=',$request->schoolid)
            ->orderBy('municipality.id')
            ->orderBy('school.name')
            ->orderBy('schoollevel.id')
            ->get();


        $output = new \Symfony\Component\Console\Output\ConsoleOutput();

        // $piedata = array();
        // foreach($items as $item) {
        //     $object = new \stdClass();
        //     $object->schoolid = $item->schoolid;
        //     $object->name = $item->schoolname;
        //     $object->labels = array();
        //     $object->datasets = array(
        //         (object)array(
        //         'data' => array(),
        //         'backgroundColor' => array()
        //         )
        //     );

        //     $survey = null;
        //     foreach($piedata as $key => $data) {
        //         if ($item->schoolid == $data->schoolid) {
        //             $survey = $key;
        //             break;
        //         }
        //     }
        //     if (!is_null($survey)){
        //         array_push($piedata[$survey]->labels, $item->levelname);
        //         array_push($piedata[$survey]->datasets[0]->data, $item->totalstudents);
        //     }else{
        //         array_push($object->labels, $item->levelname);
        //         array_push($object->datasets[0]->data, $item->totalstudents);
        //         array_push($piedata,$object);
        //     }
        // }
        // $bardata = array();
        // foreach($items as $item) {
        //     $object = new \stdClass();
        //     $object->schoolid = $item->schoolid;
        //     $object->name = $item->schoolname;
        //     $object->labels = array();
        //     $object->datasets = array(
        //         (object)array(
        //         'label'                 => 'Total Male',
        //         'backgroundColor'       => 'rgba(60,141,188,0.9)',
        //         'borderColor'           => 'rgba(60,141,188,0.8)',
        //         'pointRadius'           => false,
        //         'pointColor'            => '#3b8bba',
        //         'pointStrokeColor'      => 'rgba(60,141,188,1)',
        //         'pointHighlightFill'    => '#fff',
        //         'pointHighlightStroke'  => 'rgba(60,141,188,1)',
        //         'data' => array()
        //         ),
        //         (object)array(
        //         'label'                => 'Total Female',
        //         'backgroundColor'      => 'rgba(210, 214, 222, 1)',
        //         'borderColor'          => 'rgba(210, 214, 222, 1)',
        //         'pointRadius'          => false,
        //         'pointColor'           => 'rgba(210, 214, 222, 1)',
        //         'pointStrokeColor'     => '#c1c7d1',
        //         'pointHighlightFill'   => '#fff',
        //         'pointHighlightStroke' => 'rgba(220,220,220,1)',
        //         'data' => array()
        //         )
        //     );

        //     $survey = null;
        //     foreach($bardata as $key => $data) {
        //         if ($item->schoolid == $data->schoolid) {
        //             $survey = $key;
        //             break;
        //         }
        //     }
        //     if (!is_null($survey)){
        //         array_push($bardata[$survey]->labels, $item->levelname);
        //         array_push($bardata[$survey]->datasets[0]->data, $item->totalmale);
        //         array_push($bardata[$survey]->datasets[1]->data, $item->totalfemale);
        //     }else{
        //         array_push($object->labels, $item->levelname);
        //         array_push($object->datasets[0]->data, $item->totalmale);
        //         array_push($object->datasets[1]->data, $item->totalfemale);
        //         array_push($bardata,$object);
        //     }
        // }

        $piedata = new \stdClass();
        $piedata->labels = array();
        $piedata->datasets = array(
            (object)array(
            'data' => array(),
            'backgroundColor' => array()
            )
        );
        foreach($items as $item) {
            $piedata->schoolid = $item->schoolid;
            $piedata->name = $item->schoolname;

            array_push($piedata->labels, $item->levelname);
            array_push($piedata->datasets[0]->data, $item->totalstudents);
        }

        $bardata = new \stdClass();
        $bardata->labels = array();
        $bardata->datasets = array(
            (object)array(
            'label'                 => 'Total Male',
            'backgroundColor'       => 'rgba(60,141,188,0.9)',
            'borderColor'           => 'rgba(60,141,188,0.8)',
            'pointRadius'           => false,
            'pointColor'            => '#3b8bba',
            'pointStrokeColor'      => 'rgba(60,141,188,1)',
            'pointHighlightFill'    => '#fff',
            'pointHighlightStroke'  => 'rgba(60,141,188,1)',
            'data' => array()
            ),
            (object)array(
            'label'                => 'Total Female',
            'backgroundColor'      => 'rgba(210, 214, 222, 1)',
            'borderColor'          => 'rgba(210, 214, 222, 1)',
            'pointRadius'          => false,
            'pointColor'           => 'rgba(210, 214, 222, 1)',
            'pointStrokeColor'     => '#c1c7d1',
            'pointHighlightFill'   => '#fff',
            'pointHighlightStroke' => 'rgba(220,220,220,1)',
            'data' => array()
            )
        );
        foreach($items as $item) {
            $bardata->schoolid = $item->schoolid;
            $bardata->name = $item->schoolname;

            array_push($bardata->labels, $item->levelname);
            array_push($bardata->datasets[0]->data, $item->totalmale);
            array_push($bardata->datasets[1]->data, $item->totalfemale);

        }

        $dashdata = array(
            (object)array(
                'piedata' => $piedata,
                'bardata' => $bardata,
            )
        );
        }else{
            return response('Unauthorized.', 401);
        }
        // $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        // $output->writeln($dashdata);
        // print_r($dashdata);

        return $dashdata;
        // donutData : {
        //     labels: [
        //         'Chrome',
        //         'IE',
        //         'FireFox',
        //         'Safari',
        //         'Opera',
        //         'Navigator',
        //     ],
        //     datasets: [
        //         {
        //         data: [700,500,400,600,300,100],
        //         }
        //     ]
        //     },


    }
}
