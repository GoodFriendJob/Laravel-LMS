<?php

namespace App\Http\Controllers\Backend\Admin;
use App\Models\Auth\User;
use App\Models\Time_limit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
class TimeLimitController extends Controller
{   



    public function index(Request $request)
    {
        if (!Gate::allows('course_access')) {
            return abort(401);
        }
        $planLimit = Time_limit::all();
        // $planLimit;
        return view('backend.time_limit.create')->with('planDate',$planLimit);
    }

    
    function  create(){
        $userList = User::get();
        return view('backend.time_limit.create',compact('userList'));
    }

    function store(Request $request){
        // return $request;
        $hdnid = $request->hdnid;
        $time_limitval = str_replace("T"," ",$request->time_limit);
        $find = Time_limit::where('id',$hdnid)->get();
        if(count($find) > 0){
            
            $timeData['time_limit'] = $time_limitval;
            Time_limit::where('id',$find[0]->id)->update($timeData);
        }else{
            $time_limit = new Time_limit();
            $time_limit->time_limit = $time_limitval;
            $time_limit->save();
        }

        return redirect()->route('admin.time_limit')->withFlashSuccess(trans('alerts.backend.general.updated'));
        
    }
}
