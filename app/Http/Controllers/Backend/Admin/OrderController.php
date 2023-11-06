<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Helpers\General\EarningHelper;
use App\Models\Bundle;
use App\Models\Course;
use App\Models\Test;
use App\Models\TestsResult;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{

    /**
     * Display a listing of Orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::get();
        return view('backend.orders.index', compact('orders'));
    }

    /**
     * Display a listing of Orders via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        if (request('offline_requests') == 1) {
            $orders = Order::query()->where('payment_type', '=', 3)->orderBy('updated_at', 'desc');
        } else {
            $orders = Order::query()->orderBy('updated_at', 'desc');
        }
        
   
        return DataTables::of($orders)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($request) {
                $view = "";
                $view .= view('backend.datatable.action-view')
                    ->with(['route' => route('admin.orders.show', ['order' => $q->id]),'id'=>$q->id])->render();
                $view .= view('backend.datatable.action-extend-date')
                    ->with(['route' => route('admin.orders.show', ['order' => $q->id]),'id'=>$q->id])->render();

                $user_name = User::select('first_name')->where('id',$q->user->id)->first();
                $files = DB::table('courses')->select('user_answer.answer', 'questions.question')
                    ->leftJoin('tests', 'courses.id', '=', 'tests.course_id')
                    ->leftJoin('question_test', 'tests.id', '=', 'question_test.test_id')
                    ->leftJoin('questions', 'question_test.question_id', '=', 'questions.id')
                    ->leftJoin('user_answer', 'user_answer.question_id', '=', 'question_test.question_id')
                    ->where(['courses.id'=>$q->items[0]->item_id,'questions.questiontype'=>'7','user_answer.user_id'=>$q->user->id])
                    ->get();

                if($files->count() > 0){
                    foreach ($files as $key => $value){
                        $fs = json_decode($value->answer);
                        if ( count($fs) ) {
                            $view .= "<br>$value->question";
                            foreach($fs as $f){
                                $view .= "<br><span>$f->name</span>";
                                $view .= view('backend.datatable.action-download')
                                ->with([
                                    'route' => route('admin.orders.download', ['file' => $f->name])
                                ])->render();
                            }
                        }
                    }
                }
                
                if ($q->status == 0) {
                    $complete_order = view('backend.datatable.action-complete-order')
                        ->with(['route' => route('admin.orders.complete', ['order' => $q->id])])
                        ->render();
                    $view .= $complete_order;
                }

                if ($q->status == 0) {
                    $delete = view('backend.datatable.action-delete')
                    ->with(['route' => route('admin.orders.destroy', ['order' => $q->id])])
                    ->render();

                    $view .= $delete;
                }

                return $view;

            })
            ->addColumn('items', function ($q) {
                $items = "";
                foreach ($q->items as $key => $item) {
                    // print_r($item->item);
                    // exit;
                    if($item->item != null){
                        $key++;
                        $items .= '<a href="'.route('admin.orders.tests', ['user_id'=> $q->user_id, 'course_id'=> $item->item->id]).'">'.$key . '. ' . $item->item->title . "</a><br>";
                    }

                }
                return $items;
            })
            ->addColumn('user_email', function ($q) {
                return $q->user->email;
            })
            ->addColumn('date', function ($q) {
                return $q->created_at->diffforhumans();
            })
            ->addColumn('payment', function ($q) {
                if ($q->status == 0) {
                    $payment_status = trans('labels.backend.orders.fields.payment_status.pending');
                } elseif ($q->status == 1) {
                    $payment_status = trans('labels.backend.orders.fields.payment_status.completed');
                } else {
                    $payment_status = trans('labels.backend.orders.fields.payment_status.failed');
                }
                return $payment_status;
            })
            ->editColumn('price', function ($q) {
                return '$' . floatval($q->price);
            })
            ->rawColumns(['items', 'actions'])
            ->make();
    }

    /**
     * Complete Order manually once payment received.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function complete(Request $request)
    {
        $order = Order::findOrfail($request->order);
        $order->status = 1;
        $order->save();

        (new EarningHelper)->insert($order);

        //Generating Invoice
        generateInvoice($order);

        foreach ($order->items as $orderItem) {
            //Bundle Entries
            if($orderItem->item_type == Bundle::class){
               foreach ($orderItem->item->courses as $course){
                   $course->students()->attach($order->user_id);
               }
            }
            $orderItem->item->students()->attach($order->user_id);
        }
        return back()->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Show Order from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('backend.orders.show', compact('order'));
    }
    public function download($file) 
    {
        return response()->download("uploads".DIRECTORY_SEPARATOR."storage".DIRECTORY_SEPARATOR.$file);
    }
    public function download1($id,$user_id)
    {
        // SELECT ua.answer FROM `courses` c LEFT JOIN tests t ON c.id = t.course_id 
        // LEFT JOIN question_test qt ON t.id = qt.test_id LEFT JOIN questions q ON qt.question_id = q.id 
        // LEFT JOIN user_answer ua ON ua.question_id = qt.question_id WHERE c.id = 6 AND q.questiontype = 7 AND ua.user_id = 3 
        
        $user_name = User::select('first_name')->where('id',$user_id)->first();
        $files = DB::table('courses')->select('user_answer.answer')
            ->leftJoin('tests', 'courses.id', '=', 'tests.course_id')
            ->leftJoin('question_test', 'tests.id', '=', 'question_test.test_id')
            ->leftJoin('questions', 'question_test.question_id', '=', 'questions.id')
            ->leftJoin('user_answer', 'user_answer.question_id', '=', 'question_test.question_id')
            ->where(['courses.id'=>$id,'questions.questiontype'=>'7','user_answer.user_id'=>$user_id])
            ->get();
        if($files->count() > 0){
            $zip = new \ZipArchive();
            $fileName = $user_name->first_name.uniqid().'.zip';
            if ($zip->open(public_path('storage'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR.$fileName), \ZipArchive::CREATE)== TRUE)
            {
                // $abc = \File::files("uploads".DIRECTORY_SEPARATOR."storage");
                // print_r($files);
                // exit;
                foreach ($files as $key => $value){
                    $fs = json_decode($value->answer);
                    foreach($fs as $f){
                        $val = "uploads".DIRECTORY_SEPARATOR."storage".DIRECTORY_SEPARATOR.$f->name;
                        $relativeName = basename($val);
                        $zip->addFile($val, $relativeName);
                    }
                    
                }
                $zip->close() === false;
            }
            header("Content-type: ".mime_content_type('storage'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR.$fileName)); 
            // header("Content-type: application/zip"); 
            header("Content-Disposition: attachment; filename=$fileName");
            header("Content-length: " . filesize('storage'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR.$fileName));
            header("Pragma: no-cache");
            header("Expires: 0"); 
            // readfile('storage'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR."$fileName");
            // return response()->download('storage'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR."$fileName");
        }else{
            return redirect()->route('admin.orders.index')->withFlashSuccess('No File to Download');
        }
            
            // return response()->download(public_path($fileName));
            
            // $file = public_path("uploads".DIRECTORY_SEPARATOR."storage").DIRECTORY_SEPARATOR.$files[0]->answer;
            // file_get_contents($files[0]->answer, file_get_contents($file));
            // var_dump(file_get_contents($files[0]->answer, file_get_contents($file)));
        //   exit
        // $order = Order::findOrFail($id);
        // return view('backend.orders.show', compact('order'));
    }

    /**
     * Remove Order from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $order = Order::findOrFail($id);
        $order->items()->delete();
        $order->delete();
        return redirect()->route('admin.orders.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Orders at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('course_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Order::whereIn('id', $request->input('ids'))->get();
            foreach ($entries as $entry) {
                if ($entry->status = 1) {
                    foreach ($entry->items as $item) {
                        $item->course->students()->detach($entry->user_id);
                    }
                    $entry->items()->delete();
                    $entry->delete();
                }
            }
        }
    }

    function store(Request $request){
        
        $todt = Carbon::parse($request->toDate);
        $plan_date = $todt->year.'-'.$todt->month.'-'.$todt->day .' '.$todt->hour .':'.$todt->minute;
        $order_id = $request->order_id; 
        $data['plan_date'] = $plan_date;
        // return $order_id;
        Order::where('id',$order_id)->update($data);
        $output = array(
            'success'  => 'Date extend successfully...!' // data is saved successfully
        );
    }

    public function courseTest(Request $request, $user_id, $course_id) {
        if (! Gate::allows('test_access')) {
            return abort(401);
        }

        return view('backend.orders.tests');
    }

    
    public function getTestByCourse(Request $request)
    {
        $has_view = false;
        $tests = "";


        if ($request->course_id != "") {
            $tests = Test::query()->where('course_id', '=', $request->course_id)->orderBy('testorders', 'asc');
        }


        if (auth()->user()->can('test_view')) {
            $has_view = true;
        }
        if (auth()->user()->can('test_edit')) {
            $has_edit = true;
        }
        $tests->with(['courseTimeline' => function ($query) {
            $query->orderBy('sequence', 'desc');
        }]);

        return DataTables::of($tests)
            ->addIndexColumn()
            ->addColumn('questions', function ($q, Request $request) {
             if (count($q->questions) > 0) {
                    return "<span>".count($q->questions)."</span><a class='btn btn-success float-right' href='".route('admin.orders.questions', ['user_id'=> $request->user_id, 'course_id'=> $request->course_id, 'test_id'=> $q->id])."'><i class='fa fa-arrow-circle-o-right'></i></a> ";
                }
                return count($q->questions);
            })

            ->addColumn('course', function ($q) {
                return ($q->course) ? $q->course->title : "N/A";
            })

            ->addColumn('lesson', function ($q) {
                return ($q->lesson) ? $q->lesson->title : "N/A";
            })

            ->editColumn('published', function ($q) {
                return ($q->published == 1) ? "Yes" : "No";
            })
            ->rawColumns(['questions'])
            ->make();
    }

    public function courseTestQuestion(Request $request, $user_id, $course_id, $test_id) {
        if (! Gate::allows('test_access')) {
            return abort(401);
        }

        //$tests = Test::query()->where('course_id', '=', $request->course_id)->orderBy('testorders', 'asc');
        $lesson = Test::where('id', $test_id)->where('published', '=', 1)->firstOrFail();
        $test_result = TestsResult::where('test_id', $test_id)
                    ->where('user_id', $user_id)
                    ->first();

        $test_exists = TRUE;

        //return response()->json(['user_id'=> $user_id, 'course_id'=> $course_id, 'test_id'=> $test_id]);
        return view('backend.orders.questions', compact('lesson', 'test_result', 'test_exists'));
    }

    public function getAnswersByUser(Request $request, $user_id, $course_id, $test_id){
        $qu = DB::table('user_answer')->select('question_id')->where('user_id', $user_id)->where('test_id', $test_id)->groupBy('question_id')->get();
        $datas = [];
        foreach ($qu as $key => $value) {
            $answers = DB::table('user_answer')->select('q_id', 'answer', 'score')->where('user_id', $user_id)->where('test_id', $test_id)->where('question_id', $value->question_id)->get();
            $data = [];
            $data['question_id'] = $value->question_id;
            $data['type'] = DB::table('questions')->select('questiontype')->where('id', $value->question_id)->first()->questiontype;
            $data['ans'] = $answers;
            array_push($datas, $data);
        }
        $data = [
            'answers' => $datas,
        ];
        return response()->json($data);
    }

    public function getReportByUser(Request  $request, $user_id, $course_id, $test_id)
    {  
        $data = $request->test;
        $reported = $request->reported;

       
        //$score_temp = '0';
        $answers = DB::table('user_answer')->where('test_id', $test_id)->where('user_id', $user_id)->get();
        foreach($answers as $ans){
            //$QuestionType = DB::table('questions')->select('questiontype')->where('id', $ans->question_id)->first()->questiontype;
            
            $temp = DB::table('questions')->select('questiontype')->where('id', $ans->question_id)->first();
            if ($temp) {
                $QuestionType = $temp->questiontype;    
            } else {
                $data = [
                    "error"=> "Contact Admin: Question type not found for test_id ".$test_id.' question_id '.$ans->question_id
                ];
                echo json_encode($data);
                exit();
            }
            
            if($QuestionType != 7) DB::table('user_answer')->where('user_id', $user_id)->where('test_id', $test_id)->where('question_id', $ans->question_id)->delete();
        }
        if ($data == null) {
            $data = [
                    "error"=> "Contact Admin: arr = collecting_answers() == null "
                ];
                echo json_encode($data);
                exit();
        }
        foreach($data as $obj){
            $dataset = (array)$obj;
            $val = $dataset['value'];

            $question_val = DB::table('questions')
                ->select('content', 'questiontype')
                ->where('id','=', $dataset['key'])
                ->first();
            if($question_val != null) {

                if ($question_val->questiontype == 5) {
                    $content = json_decode($question_val->content);
                    $vals = $content[intval($dataset['value']) - 1];
                    $val = $vals->score;
                
                } else if ($question_val->questiontype == 8) {
                    $content = json_decode($question_val->content);
                    $vals = $content[intval($dataset['value']) - 1];
                    $val = $vals->score;
                } else if($question_val->questiontype == 4) {
                    $type = 'matrix-type="radio"';
                    $content_str = $question_val->content;
                    $pos = strpos($content_str, $type);
                    if($pos === false){
                        $val = 0;
                    }
                }
            }
            
            DB::table('user_answer')
                ->insert([
                    'question_id' => $dataset['key'],
                    'q_id' => $dataset['qid'],
                    'answer' => $dataset['value'],
                    'user_id' =>$user_id ,
                    'test_id' =>$test_id ,
                    'score' => $val
                ]);
        }

        //$user_id = auth()->user()->id;
        $report_id = DB::table('testreport_test')
        ->select('testreport_id')
        ->where('test_id','=',$test_id)
        ->first();
        if($report_id != null){
            if($reported){
                DB::table('user_test')->insert([
                    'user_id' => $user_id,
                    'test_id' => $test_id,
                    'reported' => $reported,
                ]);
            }
            $id = $report_id->testreport_id;
            $report_data = DB::table('testreports')->where('id',$id)->get();
            $user_question = DB::table('user_answer')->select('question_id', 'q_id', 'answer','score')->where('user_id',$user_id)->where('test_id',$test_id)->get();
            $user_textgroup = DB::table('user_textgroup')->select('textgroup_id','answer','score')->where('user_id',$user_id)->get();
            $textgroup_data = DB::table('textgroups')->get();
            // $chart_data = [];
            // $chart_ids = DB::table('chart_test')->where('test_id', $test_id)->get();
            // foreach($chart_ids as $id){
            //     array_push($chart_data, DB::table('charts')->where('id', $id->chart_id)->first());
            // }
            $chart_data = DB::table('charts')->get();
            //$questions_data = DB::table('questions')->get();
    
            $data = [
                "report_data" => $report_data,
                "user_question" => $user_question,
                "user_textgroup" => $user_textgroup,
                "chart_data" => $chart_data,
                "textgroup_data" => $textgroup_data,
                //"questions_data" => $questions_data
            ];
        } else {
            $data = [
                "error"=> "There are no report on this test"
            ];
        }
    

        //return response()->json($data, 200);
        echo json_encode($data);
        exit();
    }
     
    public function updateReportByUser(Request $request, $user_id, $course_id, $test_id)
    {

        $currentDate = Carbon::now();
        $dateCurrentDT = $currentDate->year .'-' .$currentDate->month .'-'.$currentDate->day .' '.$currentDate->hour .':'.$currentDate->minute;
        $userOrder = Order::where('user_id',$user_id)->get();

        $courseItēm = "";
        foreach($userOrder as $key => $order){
            $usercourse = OrderItem::where('order_id',$order->id)->where('item_id',$course_id)->get();
            if($usercourse != "[]"){
                $courseItēm .= $usercourse[0]->order_id;
            }
        }
        $orderlimit = Order::where('id',$courseItēm)->get();

        $expireDate = $orderlimit[0]->plan_date;

        $strLTime =  strtotime($expireDate);
        $current = strtotime($dateCurrentDT);
        //if($current <= $strLTime){
        
        $report_cont = $request->report_content;
        $tg_ids = json_decode($request->tg_ids);
        $tg_answers = json_decode($request->tg_answers);
        $tg_scores = json_decode($request->tg_scores);

        


        for($i = 0; $i < count($tg_ids); $i++){
            $ii=DB::table('user_textgroup')
            ->where('textgroup_id',$tg_ids[$i])
            ->where('user_id',$user_id)->count();
            // print_r($ii);
            // return $ii;
            if ($ii ==0)
            {
                DB::table('user_textgroup')
                    ->insert([
                        'textgroup_id' => $tg_ids[$i],
                        'answer' => $tg_answers[$i],
                        'user_id' => $user_id ,
                        'score' => $tg_scores[$i]
                    ]);
            }
            else{
                DB::table('user_textgroup')
                    ->where('textgroup_id',$tg_answers[$i])
                    ->where('user_id',$user_id)
                    ->update([
                        'answer' => $tg_answers[$i],
                        'score' => $tg_scores[$i]
                    ]);
            }
        }
        $report_id = DB::table('testreport_test')
            ->select('testreport_id')
            ->where('test_id','=', $test_id)
            ->first();
            
        if($report_id != null){
            $id = $report_id->testreport_id;
            DB::table('testreports')->where('id', $id)->update([
                'content' => $report_cont,
            ]);
        }
        $output = array(
            'success'  => 'i dati sono stati salvati correttamente' // data is saved successfully
        );
    // }else{
    //     $output = array(
    //         'success'  => 'Sorry your time is our contact your admin' // data is saved successfully
    //     );
    // }

       
   
        echo json_encode($output);
    }


    public function uploadFiles(Request $request, $user_id, $course_id, $test_id)
    {
        $destinationPath = 'uploads/storage/';
        $file_names = []; 
        $exist_files = [];
        $image_types = ['jpg', 'jpeg', 'ico', 'png', 'bmp', 'gif', 'webp', 'svg', 'tif', 'pjp', 'xbm', 'jxl', 'tif', 'jfif', 'pjpeg', 'avif'];
        $totalfiles = $request->TotalFiles;
        $question = DB::table('questions')->where('id', $request->q_id)->first();
        $number_of_files = json_decode($question->content)[0]->number;
        
        if($totalfiles <= $number_of_files){
            $answer = DB::table('user_answer')->select('answer')->where('test_id', $test_id)->where('question_id', $request->q_id)->first();
            if($answer){
                $exist_files = $answer->answer;
                $exist_files = json_decode($exist_files);
            }
            if(count($exist_files) > 0){
                $file_names = $exist_files;
            }
            if($totalfiles > 0){
                for($x = 0; $x < $totalfiles; $x++){
                    if($request->hasfile('files'.$x))
                    {   
                        $file = $request->file('files'.$x);
                        $name = $test_id.'_'.$user_id.'_'.$file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $check = $file->move($destinationPath, $name);
                        if(in_array($extension, $image_types)){
                            array_push($file_names, [
                                'name' => $name,
                                'type' => 'image',
                            ]);
                        }else {
                            array_push($file_names,[
                                'name' => $name,
                                'type' => 'other',
                            ]);
                        }
                    }
                }
            }
            // DB::table('user_answer')->where('test_id', $request->test_id)->where('question_id', $request->q_id)->delete();
            if($answer){
                DB::table('user_answer')->where('test_id', $test_id)->where('question_id', $request->q_id)->update([
                    'user_id' => $user_id,
                    'test_id' => $test_id,
                    'question_id' => $request->q_id,
                    'q_id' => $request->q_id,
                    'answer' => json_encode($file_names),
                    'score' => 0,
                ]);
            }else {
                DB::table('user_answer')->where('test_id', $test_id)->where('question_id', $request->q_id)->insert([
                    'user_id' => $user_id,
                    'test_id' => $test_id,
                    'question_id' => $request->q_id,
                    'q_id' => $request->q_id,
                    'answer' => json_encode($file_names),
                    'score' => 0,
                ]);
            }
            $output = array(
                'result'  => 'File caricati correttamente',
                'file_names' =>$file_names,
                'q_id' => $request->q_id
            );
        }else {
            $output = array(
                'result'  => 'Il numero di file deve essere inferiore a '.$number_of_files,
                'file_names' =>$file_names,
                'q_id' => $request->q_id
            );
        }
        return response()->json($output);
    }


    public function deleteFile(Request $request, $user_id, $course_id, $test_id){
        //$test_id = $request->test_id;
        $question_id = $request->question_id;
        $name = $request->name;
        //$user_id = \Auth::id();
        $files = DB::table('user_answer')->select('answer')->where('user_id', $user_id)->where('test_id', $test_id)->where('question_id', $question_id)->first()->answer;
        $files = json_decode($files);
        foreach ($files as $key => $file) {
            if($file->name == $name){
                array_splice($files, $key, 1);  
            }
        }
        $files = json_encode($files);
        DB::table('user_answer')->where('user_id', $user_id)->where('test_id', $test_id)->where('question_id', $question_id)->update([
            'user_id' => $user_id,
            'test_id' => $test_id,
            'question_id' => $question_id,
            'answer' => $files
        ]);

        $output = array(
            'success' => 'File eliminati con successo'
        );
        return response()->json($output);
    }

}
