<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Course;
use App\Models\CourseTimeline;
use App\Models\Lesson;
use App\Models\Media;
use App\Models\Test;
use App\Models\Testreport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLessonsRequest;
use App\Http\Requests\Admin\UpdateLessonsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use Yajra\DataTables\Facades\DataTables;
use DB;

class TestReportsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Lesson.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Gate::allows('lesson_access')) {
            return abort(401);
        }
        $tests = Test::where('published', '=', 1)->pluck('title', 'id')->prepend('Please select', '');

        return view('backend.testreports.index', compact('tests'));
    }

    /**
     * Display a listing of Lessons via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        /*TODO:: Show All questions if Admin, Show related if  Teacher*/
        if ($request->test_id == "")
        {
            $testreports = DB::table('testreports')
            ->select('testreports.*')
            ->orderBy('order','asc')->get();
        }   
        else 
        {
            $testreports = DB::table('testreports')
                ->join('testreport_test','testreport_test.testreport_id','=','testreports.id')
                ->select('testreports.*', 'testreport_test.test_id')
                ->where('testreport_test.test_id',$request->test_id)
                ->orderBy('order','asc')->get();
        }

        $has_view = true;  
        $has_edit = true;
        $has_delete = true;
        return DataTables::of($testreports)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                // if ($request->show_deleted == 1) {
                //     return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.testreports', 'label' => 'id', 'value' => $q->id]);
                // }
                // if ($has_view) {
                //     $view = view('backend.datatable.action-view')
                //         ->with(['route' => route('admin.testreports.show', ['testreport' => $q->id])])->render();
                // }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.testreports.edit', ['testreport' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.testreports.destroy', ['testreport' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                return $view;
            })
            ->rawColumns(['actions','content'])
            ->make();   
    }

    /**
     * Show the form for creating new Lesson.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (!Gate::allows('lesson_create')) {
        //     return abort(401);
        $tests =DB::table('tests')->select('title','id')->get();
        return view('backend.testreports.create')-> with('tests', $tests);
    }

    public function get_code()
    {
        // if (!Gate::allows('lesson_create')) {
        //     return abort(401);
        $charts =DB::table('charts')->select('short_code','id','type')->get();
        $textgroups =DB::table('textgroups')->select('short_code','id','content')->get();
        $output=array(
            'charts'=>$charts,
            'textgroups' =>$textgroups
        );
        echo json_encode($output);
    }

    /**
     * Store a newly created Lesson in storage.
     *
     * @param  \App\Http\Requests\StoreLessonsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = DB::table('testreports')->max('order') + 1;
        $tests = json_decode($request->data['test_ids']);
        $user_id = auth()->user()->id;

        $last_id = DB::table('testreports')->insertGetId([
            'title' => $request->data['title'],
            'user_id' => $user_id,
            'order' => $order,
            'content' => $request->data['content'],
            'origin_content' => $request->data['origin_content'],
            'published' => $request->data['published'],
        ]);

        for ($i = 0; $i < count($tests); $i++) {
            DB::table('testreport_test')->insert([
                'test_id' => $tests[$i],
                'testreport_id' => $last_id,
            ]);
        }

        $output = array(
            'success' => 'data is saved successfully'
        );

        echo json_encode($output);
    }

    public function update(Request $request){
        $order = DB::table('testreports')->max('order') +1 ;
        $tests = json_decode($request->data['test_ids']);
        $user_id = auth()->user()->id;

        $last_id = DB::table('testreports')->where('id',$request->data['id'])->update([
            'title' => $request->data['title'],
            'user_id' =>$user_id,
            'order' => $order,
            'content' =>$request->data['content'],
            'origin_content' =>$request->data['origin_content'],
            'published' => $request->data['published'],
        ]);

        DB::table('testreport_test')->where('testreport_id', $request->data['id'])->delete();

        for ($i =0; $i<count($tests); $i++)
        {
            DB::table('testreport_test')->insert([
                'test_id' => $tests[$i],
                'testreport_id' => $request->data['id'],
            ]);
        }

        $output = array(
            'success'  => 'data is saved successfully'
            );

         echo json_encode($output); 
    }

    /**
     * Show the form for editing Lesson.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $testreport =DB::table('testreports')->where('id',$id)->get();
        $org_content = explode("[chart id=", $testreport[0]->origin_content);
        if(count($org_content) > 1){
            $chart_id = substr($org_content[1], 0, 1);
            $charts =DB::table('charts')->where('id', $chart_id)->get();
            if(count($charts) > 0) {
                if ($charts[0]->type == 1) {
                    $content = str_replace("&quot;", "'", $testreport[0]->content);
                    $testreport[0]->content = $content;
                }
            }
        }
        $tests = Test::where('published', '=', 1)->select('title', 'id')->get();
        $current_tests =DB::table('testreport_test')->select('test_id')->where('testreport_id', $id)->get();
        // dd($tests);
        return view('backend.testreports.edit', compact('testreport', 'tests', 'current_tests'));
        
    }

    /**
     * Display Lesson.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('lesson_view')) {
            return abort(401);
        }
        $courses = Course::get()->pluck('title', 'id')->prepend('Please select', '');

        $tests = Test::where('lesson_id', $id)->get();

        $lesson = Lesson::findOrFail($id);


        return view('backend.lessons.show', compact('lesson', 'tests', 'courses'));
    }


    /**
     * Remove Lesson from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        if (!Gate::allows('lesson_delete')) {
            
            return abort(401);
        }
        
        $testReport = Testreport::findOrFail($id);
        DB::table('testreport_test')->where('testreport_id', $id)->delete();
        // $lesson->chapterStudents()->where('course_id', $lesson->course_id)->forceDelete();
        $testReport->delete();

        return back()->withFlashSuccess(__('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Lesson at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('lesson_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Lesson::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Lesson from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('lesson_delete')) {
            return abort(401);
        }
        $lesson = Lesson::onlyTrashed()->findOrFail($id);
        $lesson->restore();

        return back()->withFlashSuccess(trans('alerts.backend.general.restored'));
    }

    /**
     * Permanently delete Lesson from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('lesson_delete')) {
            return abort(401);
        }
        $lesson = Lesson::onlyTrashed()->findOrFail($id);

        if (File::exists(public_path('/storage/uploads/'.$lesson->lesson_image))) {
            File::delete(public_path('/storage/uploads/'.$lesson->lesson_image));
            File::delete(public_path('/storage/uploads/thumb/'.$lesson->lesson_image));
        }

        $timelineStep = CourseTimeline::where('model_id', '=', $id)
            ->where('course_id', '=', $lesson->course->id)->first();
        if ($timelineStep) {
            $timelineStep->delete();
        }

        $lesson->forceDelete();



        return back()->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
    public function student_report(){
        
        $user_id = auth()->user()->id;
        
        $testreport =DB::table('testreports')->where('user_id',$user_id)->get();
        // $testreport =DB::table('testreports')->get();
         //dd($testreport);
        return view('backend.reports.student_report', compact('testreport'));
    }
}
