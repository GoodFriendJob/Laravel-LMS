<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Lesson;
use App\Models\Test;
use App\Models\TestsResult;
use Illuminate\Support\Facades\Storage;
use PDF;
use Exception;
use Illuminate\Support\Str;
use Mail;

class PdfController extends Controller
{
    private $path;

    public function __construct()
    {

        // ini_set('max_execution_time', 600); // Set the maximum execution time to 60 seconds
        set_time_limit(600); // Set the maximum execution time to 60 seconds

        $path = 'frontend';
        // return $path; 
        
        if (session()->has('display_type')) {
            if (session('display_type') == 'rtl') {
                $path = 'frontend-rtl';
            } else {
                $path = 'frontend';
            }
        } else if (config('app.display_type') == 'rtl') {
            $path = 'frontend-rtl';
        }
        $this->path = $path;
    }

    public function store(Request $request)
    {

        $user_id = auth()->user()->id;
        if ($request->hasFile('pdf')) {


            $file = $request->file('pdf');
            
            // Move the uploaded PDF file to the desired location in the public folder
            $destinationPath = 'pdf/';
            $fileName = $file->getClientOriginalName();
            $file->move(public_path($destinationPath), $fileName);
            
            $getOldFiles = DB::table('user_test')->where('test_id',$request->test_id)->where('user_id',$user_id)->first();
            if ($request->classDiv == "question-ans") {
                $questionsAnspdfExist = public_path($getOldFiles->questions_ans_pdf);
                if (file_exists($questionsAnspdfExist) && $getOldFiles->questions_ans_pdf != "") {

                    // dd(public_path($getOldFiles->report_pdf));
                    unlink(public_path($getOldFiles->questions_ans_pdf));
                }
                $data['questions_ans_pdf'] = 'pdf/' . $fileName;
            } else {
                $reportpdfExist = public_path($getOldFiles->report_pdf);
                if (file_exists($reportpdfExist) && $getOldFiles->report_pdf != "") {
                    unlink(public_path($getOldFiles->report_pdf));
                }
                $data['report_pdf'] = 'pdf/' . $fileName;

                if(config('access.users.report_mail'))
                {

// dd(auth()->user()->email);
                // $token = random_int(100000, 999999);
                 Mail::send('emails.reportpdf',['name'=> auth()->user()->name,'email' => auth()->user()->email,'PDF_URL' => asset('pdf/' . $fileName)],  function($message){
                   $message->to(auth()->user()->email);
                   $message->subject('Report PDF');
               });
             }
         }
            // Perform any additional database update or response handling here

            // DB::table('user_test')
            // ->where('test_id',$request->test_id)
            // ->where('user_id',$user_id)
            // ->update($data);
            // Return a response indicating success

    //         return response()->json(['message' => 'PDF generating, please do not refresh or return to the page until done.
    // Once completed, you can see the PDF in the side menu']);

         return response()->json(['message' => 'PDF generating, please do not refresh or return to the page until done.
            Once completed, you can see the PDF in the side menu']);
     }

        // Return an error response
     return response()->json(['error' => 'Failed to store the PDF']);
 }


 public function show($course_id, $lesson_slug)
 {  
        $test_id = $course_id; //add ckd
        if(isset($_GET['test_id'])){
            $test_id = (int)$_GET['test_id'];
        }
        // return $lesson_slug;

        $test_result = "";
        $completed_lessons = "";
        $lesson = Lesson::where('slug', $lesson_slug)->where('course_id', $course_id)->where('published', '=', 1)->first();
        if ($lesson == "") {
            $lesson = Test::where('slug', $lesson_slug)->where('course_id', $course_id)->where('published', '=', 1)->firstOrFail();
            $lesson->full_text = $lesson->description;
            $test_result = NULL;
            if ($lesson) {
                $test_result = TestsResult::where('test_id', $lesson->id)
                ->where('user_id', \Auth::id())
                ->first();
            }
        }
        
        if ((int)config('lesson_timer') == 0) {
            if(!$lesson->live_lesson){
                if ($lesson->chapterStudents()->where('user_id', \Auth::id())->count() == 0) {
                    $lesson->chapterStudents()->create([
                        'model_type' => get_class($lesson),
                        'model_id' => $lesson->id,
                        'user_id' => auth()->user()->id,
                        'course_id' => $lesson->course->id
                    ]);
                }
            }
        }

        $course_lessons = $lesson->course->lessons->pluck('id')->toArray();
        $course_tests = ($lesson->course->tests ) ? $lesson->course->tests->pluck('id')->toArray() : [];
        $course_lessons = array_merge($course_lessons,$course_tests);

        $previous_lesson = $lesson->course->courseTimeline()
        ->where('sequence', '<', $lesson->courseTimeline->sequence)
        ->whereIn('model_id',$course_lessons)
        ->orderBy('sequence', 'desc')
        ->first();

        $next_lesson = $lesson->course->courseTimeline()
        ->whereIn('model_id',$course_lessons)
        ->where('sequence', '>', $lesson->courseTimeline->sequence)
        ->orderBy('sequence', 'asc')
        ->first();

        $lessons = $lesson->course->courseTimeline()
        ->whereIn('model_id',$course_lessons)
        ->orderby('sequence', 'asc')
        ->get();



        $purchased_course = $lesson->course->students()->where('user_id', \Auth::id())->count() > 0;
        $test_exists = FALSE;

        if (get_class($lesson) == 'App\Models\Test') {
            $test_exists = TRUE;
        }

        $completed_lessons = \Auth::user()->chapters()
        ->where('course_id', $lesson->course->id)
        ->get()
        ->pluck('model_id')
        ->toArray();
        $percentage = [];
        // $testIds = \DB::table('question')
        // $test_questions = \DB::select("SELECT GROUP_CONCAT(q.id) as questions_id, t.id as testid,count(t.id) as question_count FROM courses c LEFT JOIN tests t ON c.id = t.course_id LEFT JOIN questions q ON t.id = q.test_id WHERE c.id = '$course_id' GROUP BY t.id ");
        // $test_questions = \DB::select("SELECT GROUP_CONCAT(q.id) as questions_id, t.id as testid,count(t.id) as question_count FROM courses c LEFT JOIN tests t ON c.id = t.course_id LEFT JOIN questions q ON JSON_CONTAINS(t.id, CAST(q.test_id AS CHAR)) WHERE c.id = '$course_id' GROUP BY t.id ");
        $test_id_f = $lesson->id;
        $user_answers = DB::table('user_answer')->where('user_id', \Auth::id())->where('test_id', $test_id)->get();
        // $question_count = DB::table('question_test')->where('test_id', $test_id)->count();
        $first_a;
        $answers_count = 0;
        foreach ($user_answers as $key => $value) {
            if($key == 0 || $value->question_id != $first_a){
                $first_a = $value->question_id;
                $answers_count++;
            }
        }
        if($lesson->questions == '[]'){
            $percentage[$test_id] = 0;
        }else{

            if($lesson->questions != null){
                $all_cnt = $lesson->questions->count();
                if($all_cnt == 0) $all_cnt = 1;
            }else {
                $all_cnt = 1;
            }
            if($answers_count === 0 || $all_cnt === 0){
                $percentage[$test_id] = 0;
            }else{
                $percentage[$test_id] = ($answers_count/$all_cnt)*100;
            }
        }
        $testreport =DB::table('testreports')->where('id',$lesson->course->id)->get();

        $reported = DB::table('user_test')->where('test_id', $test_id)->where('user_id', \Auth::id())->first();

        // $lesson->questions = $lesson->questions->sortBy('page_number');
        // dd($answers);
        //echo "<pre>"; print_r($test_exists); die();
        // return $this->path;  

        //         $pdf = PDF::loadView($this->path . '.pdf.pdflesson',  compact('lesson', 'previous_lesson', 'next_lesson', 'test_result',
        //     'purchased_course', 'test_exists', 'lessons','test_id_f','test_id', 'reported'));
        // return $pdf->stream('document.pdf');

        return view($this->path . '.pdf.pdflesson', compact('lesson', 'previous_lesson', 'next_lesson', 'test_result',
            'purchased_course', 'test_exists', 'lessons', 'completed_lessons','percentage','test_id_f','test_id', 'reported'));
    }

    public function showreport($course_id, $lesson_slug)
    {  
        $test_id = $course_id; //add ckd
        if(isset($_GET['test_id'])){
            $test_id = (int)$_GET['test_id'];
        }
        // return $lesson_slug;

        $test_result = "";
        $completed_lessons = "";
        $lesson = Lesson::where('slug', $lesson_slug)->where('course_id', $course_id)->where('published', '=', 1)->first();
        if ($lesson == "") {
            $lesson = Test::where('slug', $lesson_slug)->where('course_id', $course_id)->where('published', '=', 1)->firstOrFail();
            $lesson->full_text = $lesson->description;
            $test_result = NULL;
            if ($lesson) {
                $test_result = TestsResult::where('test_id', $lesson->id)
                ->where('user_id', \Auth::id())
                ->first();
            }
        }
        
        if ((int)config('lesson_timer') == 0) {
            if(!$lesson->live_lesson){
                if ($lesson->chapterStudents()->where('user_id', \Auth::id())->count() == 0) {
                    $lesson->chapterStudents()->create([
                        'model_type' => get_class($lesson),
                        'model_id' => $lesson->id,
                        'user_id' => auth()->user()->id,
                        'course_id' => $lesson->course->id
                    ]);
                }
            }
        }

        $course_lessons = $lesson->course->lessons->pluck('id')->toArray();
        $course_tests = ($lesson->course->tests ) ? $lesson->course->tests->pluck('id')->toArray() : [];
        $course_lessons = array_merge($course_lessons,$course_tests);

        $previous_lesson = $lesson->course->courseTimeline()
        ->where('sequence', '<', $lesson->courseTimeline->sequence)
        ->whereIn('model_id',$course_lessons)
        ->orderBy('sequence', 'desc')
        ->first();

        $next_lesson = $lesson->course->courseTimeline()
        ->whereIn('model_id',$course_lessons)
        ->where('sequence', '>', $lesson->courseTimeline->sequence)
        ->orderBy('sequence', 'asc')
        ->first();

        $lessons = $lesson->course->courseTimeline()
        ->whereIn('model_id',$course_lessons)
        ->orderby('sequence', 'asc')
        ->get();



        $purchased_course = $lesson->course->students()->where('user_id', \Auth::id())->count() > 0;
        $test_exists = FALSE;

        if (get_class($lesson) == 'App\Models\Test') {
            $test_exists = TRUE;
        }

        $completed_lessons = \Auth::user()->chapters()
        ->where('course_id', $lesson->course->id)
        ->get()
        ->pluck('model_id')
        ->toArray();
        $percentage = [];
        // $testIds = \DB::table('question')
        // $test_questions = \DB::select("SELECT GROUP_CONCAT(q.id) as questions_id, t.id as testid,count(t.id) as question_count FROM courses c LEFT JOIN tests t ON c.id = t.course_id LEFT JOIN questions q ON t.id = q.test_id WHERE c.id = '$course_id' GROUP BY t.id ");
        // $test_questions = \DB::select("SELECT GROUP_CONCAT(q.id) as questions_id, t.id as testid,count(t.id) as question_count FROM courses c LEFT JOIN tests t ON c.id = t.course_id LEFT JOIN questions q ON JSON_CONTAINS(t.id, CAST(q.test_id AS CHAR)) WHERE c.id = '$course_id' GROUP BY t.id ");
        $test_id_f = $lesson->id;
        $user_answers = DB::table('user_answer')->where('user_id', \Auth::id())->where('test_id', $test_id)->get();
        // $question_count = DB::table('question_test')->where('test_id', $test_id)->count();
        $first_a;
        $answers_count = 0;
        foreach ($user_answers as $key => $value) {
            if($key == 0 || $value->question_id != $first_a){
                $first_a = $value->question_id;
                $answers_count++;
            }
        }
        if($lesson->questions == '[]'){
            $percentage[$test_id] = 0;
        }else{

            if($lesson->questions != null){
                $all_cnt = $lesson->questions->count();
                if($all_cnt == 0) $all_cnt = 1;
            }else {
                $all_cnt = 1;
            }
            if($answers_count === 0 || $all_cnt === 0){
                $percentage[$test_id] = 0;
            }else{
                $percentage[$test_id] = ($answers_count/$all_cnt)*100;
            }
        }
        $testreport =DB::table('testreports')->where('id',$lesson->course->id)->get();

        $reported = DB::table('user_test')->where('test_id', $test_id)->where('user_id', \Auth::id())->first();

        // $lesson->questions = $lesson->questions->sortBy('page_number');
        // dd($answers);
        //echo "<pre>"; print_r($test_exists); die();
        // return $this->path;  

        //         $pdf = PDF::loadView($this->path . '.pdf.pdflesson',  compact('lesson', 'previous_lesson', 'next_lesson', 'test_result',
        //     'purchased_course', 'test_exists', 'lessons','test_id_f','test_id', 'reported'));
        // return $pdf->stream('document.pdf');

        return view($this->path . '.pdf.pdfreportlesson', compact('lesson', 'previous_lesson', 'next_lesson', 'test_result',
            'purchased_course', 'test_exists', 'lessons', 'completed_lessons','percentage','test_id_f','test_id', 'reported'));
    }

    public function get_answers_fill(Request $request){
        $test_id = $request->test_id;
        $user_id = auth()->user()->id;
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



        echo json_encode($data) ;
    } 

    public function get_answers_fill_report(Request $request){
        $test_id = $request->test_id;
        $user_id = auth()->user()->id;
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



        echo json_encode($data) ;
    }

    public function get_report(Request  $request)
    {  
        $data = $request->test;
        $test_id = $request->test_id;
        $user_id = auth()->user()->id;
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
            
            if($QuestionType != 7) DB::table('user_answer')->where('user_id', \Auth::id())->where('test_id', $test_id)->where('question_id', $ans->question_id)->delete();
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

        $user_id = auth()->user()->id;
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



public function generatePDF(Request $request)
{
    try {
        // Get the image data from the form input
        $imageData = $request->input('image_data');
        // Extract the base64-encoded image content from the Data URL
        $imageData = substr($imageData, strpos($imageData, ',') + 1);

        // Optimize and save the image as a temporary file
        $temp_img = Str::random(5) . '.png';
        $tempImagePath = storage_path('app/' . $temp_img);
        file_put_contents($tempImagePath, base64_decode($imageData));

        // Generate the PDF using Dompdf
        $pdf = PDF::loadView($this->path . '.pdf.pdf_template', ['imagePath' => $tempImagePath]);
        // Replace 'pdf_template' with the name of the blade template you want to use

        // Set the PDF page size to match the image size
        list($width, $height) = getimagesize($tempImagePath);
        if ($height > 1000) {
            // You can also try increasing memory and execution time limits here if necessary
            ini_set('memory_limit', '256M');
            ini_set('max_execution_time', 300); // 5 minutes
            $pdf->setPaper(array(0, 0, $width, $height));
        } else {
            $pdf->setPaper('a4');
        }

        // Save the PDF in the public/pdf folder with the specified name
        $pdfFileName = Str::random(5) . '.question_ans.pdf';
        $pdfPath = public_path('pdf/' . $pdfFileName);

        // Save the PDF to the specified path
        $pdf->save($pdfPath);

        unlink($tempImagePath);

        // Stream the generated PDF to the browser
        return $pdf->stream($pdfFileName);
    } catch (\Exception $ex) {
        return response()->json(['error' => $ex->getMessage()], 500);
    }
}




}
