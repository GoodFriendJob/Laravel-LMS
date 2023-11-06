<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Textgroup;
use App\Models\QuestionsOption;
use App\Models\Test;
use App\Models\Course;

use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuestionsRequest;
use App\Http\Requests\Admin\UpdateQuestionsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use Yajra\DataTables\Facades\DataTables;
use DB;

class TextGroupsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Question.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (!Gate::allows('textgroup_access')) {
        //     return abort(401);
        // }        
      
        $tests = Test::where('published', '=', 1)->pluck('title', 'id')->prepend('Please select', '');

        return view('backend.textgroups.index', compact('tests'));
   
    }

    public function getData(Request $request)
    {       
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        /*TODO:: Show All questions if Admin, Show related if  Teacher*/
        if ($request->test_id == "")
        {
            $textgroups = DB::table('textgroups')
            ->select('textgroups.*')
            ->orderBy('text_order','asc')->get();
        }   
        else 
        {
            $textgroups = DB::table('textgroups')
                ->join('textgroup_test','textgroup_test.text_id','=','textgroups.id')
                ->select('textgroups.*', 'textgroup_test.test_id')
                ->where('textgroup_test.test_id',$request->test_id)
                ->orderBy('text_order','asc')->get();
        }
        // if (!auth()->user()->role('administrator')) {
        //     $textgroups->where('user_id', '=', auth()->user()->id);
        // }
        // $textgroups = TextGroup::latest()->get();
        // var_dump($textgroups);
        // if ($request->show_deleted == 1) {
        //     if (!Gate::allows('question_delete')) {
        //         return abort(401);
        //     }
        //     $textgroups->onlyTrashed()->get();
        // }

        // if (auth()->user()->can('question_view')) {
        //     $has_view = true;
        // }
        // if (auth()->user()->can('question_edit')) {
        //     $has_edit = true;
        // }
        // if (auth()->user()->can('question_delete')) {
        //     $has_delete = true;
        //}
        $has_view = true;  
        $has_edit = true;
        $has_delete = true;
        return DataTables::of($textgroups)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                // if ($request->show_deleted == 1) {
                //     return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.textgroups', 'label' => 'id', 'value' => $q->id]);
                // }
                // if ($has_view) {
                //     $view = view('backend.datatable.action-view')
                //         ->with(['route' => route('admin.textgroups.show', ['textgroup' => $q->id])])->render();
                // }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.textgroups.edit', ['textgroup' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.textgroups.destroy', ['textgroup' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                return $view;
            })
            ->rawColumns(['actions','content'])
            ->make();   
          
    }



    public function create()
    {
        if (!Gate::allows('question_create')) {
            return abort(401);
        }

        $course_list =DB::table('tests')            
            ->join('courses', 'tests.course_id', '=', 'courses.id')
            ->select('course_id','courses.title')
            ->groupBy('course_id')->get();
        $course_list= json_decode(json_encode($course_list),true);

        for ($i=0;$i <count($course_list);$i++)
        {
            $temp =DB::table('tests')
                ->select('id','title')
                ->where('course_id',$course_list[$i]['course_id'])->get();
            $course_test_list[$i] = json_decode(json_encode($temp),true);                
        }        
      
        $tests =DB::table('tests')->select('title','id')->get();

        $question_count = DB::table('questions')->count();
        if ( $question_count==0)
        {
            $question_infos="";
            $question_list="";

            return view('backend.questions.create')-> with('tests', $tests)
            ->with('course_list',$course_list)->with('course_test_list',$course_test_list);
        }
        else
        {

            $test_list =DB::table('question_test')    
            ->select('test_id')
            ->groupBy('test_id')->get();
            $test_list= json_decode(json_encode($test_list),true);

            for ($i=0;$i <count($test_list);$i++)
            {
                $temp =DB::table('questions')
                    ->join('question_test','questions.id','=','question_test.question_id' )
                    ->select('id','question')
                    ->where('question_test.test_id',$test_list[$i]['test_id'])->get();
                    
                $question_list[$test_list[$i]['test_id']] = json_decode(json_encode($temp),true);                
            }
       
            return view('backend.textgroups.create')-> with('tests', $tests)
                ->with('course_list',$course_list)->with('course_test_list',$course_test_list)->with('test_list',$test_list)->with('question_list',$question_list);
        }
        
    }


   
    public function edit($id)
    {
        $course_list =DB::table('tests')            
            ->join('courses', 'tests.course_id', '=', 'courses.id')
            ->select('course_id','courses.title')
            ->groupBy('course_id')->get();
        $course_list= json_decode(json_encode($course_list),true);

        for ($i=0;$i <count($course_list);$i++)
        {
            $temp =DB::table('tests')
                ->select('id','title')
                ->where('course_id',$course_list[$i]['course_id'])->get();
            $course_test_list[$i] = json_decode(json_encode($temp),true);                
        }        
      
        $tests =DB::table('tests')->select('title','id')->get();

        $test_list =DB::table('question_test')    
        ->select('test_id')
        ->groupBy('test_id')->get();
        $test_list= json_decode(json_encode($test_list),true);

        for ($i=0;$i <count($test_list);$i++)
        {
            $temp =DB::table('questions')
                ->join('question_test','questions.id','=','question_test.question_id' )
                ->select('id','question')
                ->where('question_test.test_id',$test_list[$i]['test_id'])->get();
                
            $question_list[$test_list[$i]['test_id']] = json_decode(json_encode($temp),true);                
        }
        
        $question_infos = DB::table('questions')
        ->select('questions.id','questions.questiontype','questions.question','questions.content', 'questions.score')
        ->orderBy('questions.id','asc')->get();

        $current_tests =DB::table('textgroup_test')->select('test_id')->where('text_id', $id)->get();
        
        $current_text= DB::table('textgroups')
            ->select('*')
            ->where('id', $id)
            ->get();
        $current_text =json_decode(json_encode($current_text[0]));
     
                    
        return view('backend.textgroups.edit')->with('current_textgroup',$current_text)->with('current_tests',$current_tests)->with('question_infos', $question_infos)-> with('tests', $tests)
            ->with('course_list',$course_list)->with('course_test_list',$course_test_list)->with('test_list',$test_list)->with('question_list',$question_list);
    
    
    }

    public function get_info(Request  $request)
    {
        $data= DB::table('questions')->where('id','=',$request->id)->get();  
         echo json_encode($data);   
    }

    public function store(Request  $request)
    {
        $id = DB::table('textgroups')->max('id') + 1;
        $shortcode = '[text id=' . $id . ']';
        $text_order = DB::table('textgroups')->max('text_order') + 1;
        $tests = json_decode($request->data['test_ids']);
        $user_id = auth()->user()->id;
        
        $logics = json_decode($request->data['logic']);
        if(is_array($logics) || is_object($logics)){
            foreach($logics as $logic){
                if(is_array($logic) || is_object($logic)){
                    foreach($logic as $key => $value){
                        $tests_question = DB::table('question_test')->where('question_id', $value[1])->get();
                        $exists = false;
                        foreach($tests_question as $q){
                            if(!in_array($q->test_id, $tests)){
                                $exists = false;
                                break;
                            }
                        }
                        if($exists == false){
                            foreach($tests as $test){
                                DB::table('question_test')->where('question_id', $value[1])->where('test_id', $test)->delete();
                                DB::table('question_test')->insert([
                                    'question_id' => $value[1],
                                    'test_id' => $test
                                ]);
                            }
                        }
                    }
                }
            }
        }
        $last_id = DB::table('textgroups')->insertGetId([
            'title' => $request->data['title'],
            'score' => $request->data['score'],
            'user_id' => $user_id,
            'text_order' => $text_order,
            'content' => $request->data['content'],
            'logic' => $request->data['logic'],
            'short_code' => $shortcode

        ]);
        // var_dump($last_id);

        // $short_code='[ipt_fsqm_form id="'+ (string)$last_id +'"]';
        // var_dump($short_code);
        // DB::table('textgroups')
        // ->where('id', $last_id)
        // ->update([
        //     'short_code' => $short_code
        // ]);

        for ($i = 0; $i < count($tests); $i++) {
            DB::table('textgroup_test')->insert([
                'test_id' => $tests[$i],
                'text_id' => $last_id
            ]);
        }

        $output = array(
            'success' => 'data is saved successfully'
        );

        echo json_encode($output);
    }

    public function update(Request $request)
    {  
        $tests = json_decode($request->data['test_ids']);
        $user_id = auth()->user()->id;  
        DB::table('textgroups')
                ->where('id',$request->data['text_id'])
                ->update([
                    'title' => $request->data['title'],
                    'score' => $request->data['score'],
                    'user_id' =>$user_id,
                    'content' =>$request->data['content'],
                    'logic' =>$request->data['logic']

            ]);
       
        for ($i =0; $i<count($tests); $i++)
        {   
            DB::table('textgroup_test')
                ->where('text_id',$request->data['text_id'])
                ->updateOrInsert([
                    'test_id' => $tests[$i],
                    'text_id' => $request->data['text_id']
            ]);
            
        }

        $logics = json_decode($request->data['logic']);
        if(is_array($logics) || is_object($logics)){
            foreach($logics as $logic){
                if(is_array($logic) || is_object($logic)){
                    foreach($logic as $key => $value){
                        $tests_question = DB::table('question_test')->where('question_id', $value[1])->get();
                        $exists = false;
                        foreach($tests_question as $q){
                            if(!in_array($q->test_id, $tests)){
                                $exists = false;
                                break;
                            }
                        }
                        if($exists == false){
                            foreach($tests as $test){
                                DB::table('question_test')->where('question_id', $value[1])->where('test_id', $test)->delete();
                                DB::table('question_test')->insert([
                                    'question_id' => $value[1],
                                    'test_id' => $test
                                ]);
                            }
                        }
                    }
                }
            }
        }
        $output = array(
            'success'  => 'data is updated successfully'
            );

         echo json_encode($output); 
    }



    public function destroy($id)
    {
        // if (!Gate::allows('textgroup_delete')) {
        //     return abort(401);
        // }
        $textgroup = DB::table("textgroups")->where("id",$id)->get();
    
            DB::table('textgroup_test')->where('text_id', $id)->delete();
            DB::table('textgroups')->where('id', $id)->delete();
        // $textgroup->delete();

        return redirect()->route('admin.textgroups.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
    
   
}
