<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Models\Question;
use App\Models\QuestionsOption;
use App\Models\Test;
use App\Models\Course;

use FontLib\Table\Type\name;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuestionsRequest;
use App\Http\Requests\Admin\UpdateQuestionsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use Yajra\DataTables\Facades\DataTables;
use DB;

class ChartsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Question.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (!Gate::allows('question_access')) {
        //     return abort(401);
        // }
        
        $tests = Test::where('published', '=', 1)->pluck('title', 'id')->prepend('Please select', '');

        return view('backend.charts.index', compact('tests'));
    }


    /**
     * Display a listing of Questions via ajax DataTable.
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
            
            $charts = DB::table('charts')
            ->select('charts.*')
            ->orderBy('order','asc')->get();
        
        else 
        {
            $charts = DB::table('charts')
                ->join('chart_test','chart_test.chart_id','=','charts.id')
                ->select('charts.*', 'chart_test.test_id')
                ->where('chart_test.test_id',$request->test_id)
                ->orderBy('order','asc')->get();
        }

        $has_view = true;  
        $has_edit = true;
        $has_delete = true;

        return DataTables::of($charts)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.charts.edit', ['chart' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.charts.destroy', ['chart' => $q->id, 'test_id' => $request->test_id??''])])
                        ->render();
                    $view .= $delete;
                }
                return $view;
            })
            ->rawColumns(['actions'])
            ->make();
    }

    public function create(Request $request)
    {
        // if (!Gate::allows('question_create')) {
        //     return abort(401);
        // }

        $course_list =DB::table('tests')            
            ->join('courses', 'tests.course_id', '=', 'courses.id')
            ->select('course_id','courses.title')
            ->groupBy('course_id')->get();
        $course_list= json_decode(json_encode($course_list),true);
        $c_l = count($course_list);//add ckd
        for ($i=0; $i <$c_l; $i++)
        {
            $temp =DB::table('tests')
                ->select('id','title')
                ->where('course_id',$course_list[$i]['course_id'])->get();
            $course_test_list[$i] = json_decode(json_encode($temp),true);                
        }   
        $tests =DB::table('tests')->select('title','id')->get();

        $question_count = DB::table('questions')->count();
        $question_list = $request->question_list;
        $textgroup_list = $request->textgroup_list;
        $tests_ids = $request->test_ids;
        if ($question_count==0)
        {
            //$question_infos="";
            $question_list="";
            $textgroup_list="";
            return view('backend.charts.create')-> with('tests', $tests)
                ->with('course_list',$course_list)->with('course_test_list',$course_test_list);
        }
        else
        {
            if(is_array($question_list) || is_object($question_list)){
                foreach($question_list as $key => $question){
                    $tests_question = DB::table('question_test')->where('question_id', $question)->get();
                    $exists = false;
                    foreach($tests_question as $q){
                        if(!in_array($q->test_id, $tests_ids)){
                            $exists = false;
                            break;
                        }
                    }
                    if($exists == false){
                        foreach($tests_ids as $test){
                            DB::table('question_test')->where('question_id', $question)->where('test_id', $test)->delete();
                            DB::table('question_test')->insert([
                                'question_id' => $question,
                                'test_id' => $test
                            ]);
                        }
                    }
                }
            }
            if(is_array($textgroup_list) || is_object($textgroup_list)){
                foreach ($textgroup_list as $key => $value) {
                    $text_data = DB::table('textgroups')->where('id', $value)->first();
                    $t_logics = json_decode($text_data->logic);
                    if(is_array($t_logics) || is_object($t_logics)){
                        foreach ($t_logics as $key => $sub_logics) {
                            foreach($sub_logics as $logic){
                                $tests_question = DB::table('question_test')->where('question_id', $logic[1])->get();
                                foreach($tests_question as $q){
                                    if(!in_array($q->test_id, $tests_ids)){
                                        $exists = false;
                                        break;
                                    }
                                }
                                if($exists == false){
                                    foreach($tests_ids as $test){
                                        DB::table('question_test')->where('question_id', $logic[1])->where('test_id', $test)->delete();
                                        DB::table('question_test')->insert([
                                            'question_id' => $logic[1],
                                            'test_id' => $test
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $test_question_list =DB::table('question_test')    
            ->select('test_id')
            ->groupBy('test_id')->get();
            $test_question_list= json_decode(json_encode($test_question_list),true);
            $test_textgroup_list =DB::table('textgroup_test')    
            ->select('test_id')
            ->groupBy('test_id')->get();
            $test_textgroup_list= json_decode(json_encode($test_textgroup_list),true);

            for ($i=0;$i <count($test_question_list);$i++)
            {
                $temp =DB::table('questions')
                    ->join('question_test','questions.id','=','question_test.question_id' )
                    ->select('id','question','questiontype','score','questions.test_id as qtest_id')
                    ->where('question_test.test_id',$test_question_list[$i]['test_id'])->get();
                    
                $question_list[$test_question_list[$i]['test_id']] = json_decode(json_encode($temp),true);
            }
            
            for ($i=0;$i <count($test_textgroup_list);$i++){
                $temp2 =DB::table('textgroups')
                    ->join('textgroup_test','textgroups.id','=','textgroup_test.text_id' )
                    ->select('id','title')
                    ->where('textgroup_test.test_id',$test_textgroup_list[$i]['test_id'])->get();
                    
                $textgroup_list[$test_textgroup_list[$i]['test_id']] = json_decode(json_encode($temp2),true);
            }

            
            $matrix_questions = $temp =DB::table('questions')
                ->select('id','content')
                ->where('questiontype','4')->get();

            foreach ($matrix_questions as $key => $value) {
                $rowcols = $this->getMatrixInformation($value->content);
                $matrix_questions[$key]->rowcols = $rowcols;
            }
            $matrix_questions = json_decode(json_encode($matrix_questions),true);
            
            $file_questions = $temp = DB::table('questions')
                ->select('id', 'content')
                ->where('questiontype', '7')->get();

            foreach($file_questions as $key => $value){
                if (isset($value->content)) {
                    $decodedContent = json_decode($value->content);
            
                    if ($decodedContent !== null && is_array($decodedContent) && isset($decodedContent[0]->number)) {
                        $file_num = $decodedContent[0]->number;
                        $file_questions[$key]->file_num = $file_num; 
                    } 
                }
            }
            $file_questions = json_decode(json_encode($file_questions), true);

            return view('backend.charts.create')-> with('tests', $tests)->with('course_list',$course_list)
                ->with('course_test_list',$course_test_list)->with('test_question_list',$test_question_list)
                ->with('test_textgroup_list', $test_textgroup_list)->with('question_list',$question_list)
                ->with('textgroup_list',$textgroup_list)->with('question_row_list', $matrix_questions)->with('question_file_list', $file_questions);
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

        $question_count = DB::table('questions')->count();
        if ( $question_count==0)
        {
            //$question_infos="";
            $question_list="";
            $textgroup_list="";
            return view('backend.questions.create')-> with('tests', $tests)
                ->with('course_list',$course_list)->with('course_test_list',$course_test_list);
        }
        else
        {
            $test_question_list =DB::table('question_test')    
            ->select('test_id')
            ->groupBy('test_id')->get();
            $test_question_list= json_decode(json_encode($test_question_list),true);
            $test_textgroup_list =DB::table('textgroup_test')    
            ->select('test_id')
            ->groupBy('test_id')->get();
            $test_textgroup_list= json_decode(json_encode($test_textgroup_list),true);

            for ($i=0;$i <count($test_question_list);$i++)
            {
                $temp =DB::table('questions')
                    ->join('question_test','questions.id','=','question_test.question_id' )
                    ->select('id','question','questiontype','score','questions.test_id as qtest_id')
                    //->select('id','question')
                    ->where('question_test.test_id',$test_question_list[$i]['test_id'])->get();                    
                $question_list[$test_question_list[$i]['test_id']] = json_decode(json_encode($temp),true);
            }
            for ($i=0;$i <count($test_textgroup_list);$i++){    
                $temp2 =DB::table('textgroups')
                    ->join('textgroup_test','textgroups.id','=','textgroup_test.text_id' )
                    ->select('id','title')
                    ->where('textgroup_test.test_id',$test_textgroup_list[$i]['test_id'])->get();                    
                $textgroup_list[$test_textgroup_list[$i]['test_id']] = json_decode(json_encode($temp2),true);
            }

            $chart = DB::table('charts')->where('id', $id)->get()->toArray();//add ckd comment
            $chart = json_decode(json_encode($chart,true));//add ckd comment
            //$chart = DB::table('charts')->where('id', $id)->first();//add ckd

            $current_tests =DB::table('chart_test')->select('test_id')->where('chart_id', $id)->get();

            $matrix_questions = $temp =DB::table('questions')
                ->select('id','content')
                ->where('questiontype','4')->get();

            foreach ($matrix_questions as $key=>$value) {
                $rowcols = $this->getMatrixInformation($value->content);
                $matrix_questions[$key]->rowcols = $rowcols;
            }
            $matrix_questions = json_decode(json_encode($matrix_questions),true);

            $file_questions = $temp = DB::table('questions')
                ->select('id', 'content')
                ->where('questiontype', '7')->get();

            foreach($file_questions as $key => $value){
                if(is_array($value->content) && isset($value->content)){
                    $file_num = json_decode($value->content)[0]->number;
                    $file_questions[$key]->file_num = $file_num; 
                }else{
                    $file_questions[$key]->file_num = 0;
                }
            }
            $file_questions = json_decode(json_encode($file_questions), true);
            
            return view('backend.charts.edit')->with('chart',$chart)->with('current_tests',$current_tests)->with('tests', $tests)->with('course_list',$course_list)
                ->with('course_test_list',$course_test_list)->with('test_question_list',$test_question_list)->with('test_textgroup_list', $test_textgroup_list)
                ->with('question_list',$question_list)->with('textgroup_list',$textgroup_list)->with('question_row_list', $matrix_questions)->with('question_file_list', $file_questions);
        }
        
    }

    function getMatrixInformation($content) {
        $tempArray = explode('<tr id="', $content);
        if (sizeof($tempArray) > 0) {
            $columnInfoString = $tempArray[1];
            $columnInforArray = explode('class="form-label">', $columnInfoString);
            $cols = null;
            foreach ($columnInforArray as $key =>$value) {
                $colnameArray = explode('</label>', $value);
                if ($key > 0)
                    $cols[$key-1] = $colnameArray[0];
            }
        }
        $rows = null;
        foreach ($tempArray as $key => $val) {
            if ($key > 1) {
                $rowInfoArray = explode('class="form-label ">', $val);
                $rowInfoString = $rowInfoArray[1];
                $rownameArray = explode('</label></td>', $rowInfoString);
                $rows[$key-2] = $rownameArray[0];
            }
        }
        $tempInputArray = explode('<input id="', $content);
        $input_ids = null;
        foreach ($tempInputArray as $key => $value) {
            if ($key > 0) {
                $input_ids[$key-1] = explode('" type="', $value)[0];
            }
        }
        if(!empty($cols)){

            $rowcols = null;
            $index = -1;
            $is_checkbox = $this->isMatrixRadio($tempInputArray);
            foreach ($rows as $row_key => $row_val) {
                foreach ($cols as $col_key => $col_val) {
                    $index++;
                    if (!$is_checkbox) {
                        $id_num = str_replace("q_id", "", $input_ids[$index]);
                        $rowcols[$index] = $row_val.'.'.$col_val.'.'.$id_num;
                    }
                    else {
                        if ($col_key == 0) {
                            $id_num = str_replace("q_id", "", $input_ids[$index]);
                            $rowcols[$index] = $row_val.'.'.$id_num;
                        }
                    }
                }
            }
            return $rowcols;
        }
    }

    function isMatrixRadio($tempInputArray) {
        $is_radio = false;
        foreach ($tempInputArray as $key => $value) {
            if ($key > 0) {
                $checkArray = explode('type="radio"', $value);
                if (sizeof($checkArray) > 1) {
                    $is_radio = true;
                }
            }
        }
        return $is_radio;
    }

    public function save_chart(Request  $request)
    {
        $reqData = $request->all();
        $result = DB::table('charts')->where('id', (int)$reqData["id"])->update([
            'ctxData' => $reqData["ctxData"], 'type' => $reqData["type"]
        ]);
        $data = [
            'success' => 'i dati sono stati salvati correttamente!',
        ];
        return response()->json($data, 200);
    }

    public function get_chart_options(Request  $request)
    {
        $reqData = $request->all();
        $data = [
            'ctxData' => DB::table('charts')->where('id', (int)$reqData["id"])->get("ctxData"),
        ];
        return response()->json($data, 200);
    }
    
    public function store(Request  $request)
    {
        $id = DB::table('charts')->max('id')+1;
        $order = DB::table('charts')->max('order') +1 ;
        $tests = json_decode($request->post('test_ids'));
        $user_id = auth()->user()->id;
        $shortcode='[chart id='.$id.']';
        $upid= $request->post('up');

        $type_id = $request->post('type_id');//add ckd
        $title = $request->post('title');//add ckd
        $content = $request->post('content');

        if((int)$upid > 0){
            $result = DB::table('charts')->where('id', (int)$upid)->update([
                'title' => $title,
                'user_id' =>$user_id,
                'type' => $type_id,
                'content' =>$content,
                'short_code'=>$shortcode
            ]);

            for ($i =0; $i<count($tests); $i++)
            {
                DB::table('chart_test')->where('chart_id', (int)$upid)->update([
                    'test_id' => $tests[$i]
                ]);
            }

            $data = [
                'up'    => $upid,
                'success'    => 'data is updated successfully',
            ];
        }
        else{
            $last_id= DB::table('charts')->insertGetId([
                'title' => $title,
                'user_id' =>$user_id,
                'type' => $type_id,
                'order' => $order,
                'content' =>$content,
                'short_code'=>$shortcode
            ]);

            for ($i =0; $i<count($tests); $i++)
            {
                DB::table('chart_test')->insert([
                    'test_id' => $tests[$i],
                    'chart_id' => $last_id,
                ]);
            }

            $data = [
                'up'    => $last_id,
                'success'    => 'data is saved successfully',
            ];
        }

        /*add ckd $output = array(
             'success'  => 'data is saved successfully',
             'up'=>$last_id
             );
          echo json_encode($output);*/

        return response()->json($data, 200);
    }

    public function update(Request $request)
    {  
        //$tests = json_decode($request->data['test_ids']);
        $tests = json_decode($request->post('test_ids'));
        $user_id = auth()->user()->id;  
        DB::table('charts')
                ->where('id',$request->post('id'))
                ->update([
                    'title' => $request->post('title'),
                    'user_id' =>$user_id,
                    'type' => $request->post('type_id'),
                   // 'order' => $order,
                    'content' =>$request->post('content'),

            ]);
       
        for ($i =0; $i<count($tests); $i++)
        {
            DB::table('chart_test')
                ->where('chart_id',$request->post('id'))
                ->updateOrInsert([
                    'test_id' => $tests[$i],
                    'chart_id' => $request->post('id')
            ]);
            
        }

        $output = array(
            'success'  => 'data is updated successfully'
            );

         echo json_encode($output); 
    }

    public function order_edit(Request  $request)
    {     
        $data = json_decode($request->id_info);
        $min_order =min($data);
    
        for ($i = 0; $i<count($data); $i++)
        {
            DB::table('questions')
            ->where('id', $data[$i])
            ->update(['questionorder' => $i+$min_order]);               
        }  

         $output = array(
             'success'  => 'The order is updated successfully'
             );

         echo json_encode($output); 
    }

    public function get_info(Request $request)
    {
        $q_list = json_decode(json_encode($request->question_list,true));
        $t_list = json_decode(json_encode($request->textgroup_list,true));
        $tests_ids = $request->test_ids;
        if(is_array($q_list) || is_object($q_list)){
            foreach($q_list as $key => $question){
                $tests_question = DB::table('question_test')->where('question_id', $question)->get();
                $exists = false;
                foreach($tests_question as $q){
                    if(!in_array($q->test_id, $tests_ids)){
                        $exists = false;
                        break;
                    }
                }
                if($exists == false){
                    foreach($tests_ids as $test){
                        DB::table('question_test')->where('question_id', $question)->where('test_id', $test)->delete();
                        DB::table('question_test')->insert([
                            'question_id' => $question,
                            'test_id' => $test
                        ]);
                    }
                }
            }
        }
        $qdata=[];$tdata=[];
        if ($q_list != null) 
            for ($i=0;$i< count($q_list);$i++)
            {
                $qdata[$i]= DB::table('questions')->select("score","id","questiontype")->where('id','=',$q_list[$i])->get()->toArray(); 

               // $vdata[$i]= DB::table('questions')->select("content","id")->where('id','=',$q_list[$i])->where('questiontype','=','9')->get()->toArray();   
            }
        else
            $qdata ="";
        if ($t_list !=null){
            for ($i=0;$i< count($t_list);$i++)
            {
                $tdata[$i]= DB::table('textgroups')->select("score","id")->where('id','=',$t_list[$i])->get()->toArray();
            };
            foreach ($t_list as $key => $value) {
                $text_data = DB::table('textgroups')->where('id', $value)->first();
                $t_logics = json_decode($text_data->logic);
                if(is_array($t_logics) || is_object($t_logics)){
                    foreach ($t_logics as $key => $sub_logics) {
                        foreach($sub_logics as $logic){
                            $tests_question = DB::table('question_test')->where('question_id', $logic[1])->get();
                            foreach($tests_question as $q){
                                if(!in_array($q->test_id, $tests_ids)){
                                    $exists = false;
                                    break;
                                }
                            }
                            if($exists == false){
                                foreach($tests_ids as $test){
                                    DB::table('question_test')->where('question_id', $logic[1])->where('test_id', $test)->delete();
                                    DB::table('question_test')->insert([
                                        'question_id' => $logic[1],
                                        'test_id' => $test
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }else{
            $tdata="";
        }
        $data= array(
            'tdata' => $tdata,
            'qdata' => $qdata,
            //'vdata' => $vdata,
        );
        // print_r($data);
        // die;
        echo json_encode($data);   
    }


    public function get_table(Request $request)
    {
       $q_list = $request->question_list1;
       $t_list = $request->data_testid;

       $q_list = trim($q_list,"+");
       $questions = explode('question', $q_list);
       $questions = array_diff($questions,[""]);
       $questions = array_slice($questions, 0, count($questions));
       
       //$qdata=[];
       $tdata=[];
       $qdata1=[];
       $arr=[];
       //$qdata2=[];
       
       for ($i=0;$i< count($questions);$i++){
            //$qdata[$i]= DB::table('questions')->select('test_id')->where('id','=',$questions[$i])->get();
            $qdata1[$i]= DB::table('questions')->select('id','test_id')->where('id','=',$questions[$i])->get();
            //$qdata2[$i]= DB::table('questions')->select('id','test_id','score')->where('id','=',$questions[$i])->get();
        }

         foreach ($qdata1 as $key=>$value) {
            $arr[$value[0]->test_id][]= array(
                'id'=>$value[0]->id,
            );
        }
        $html = '';

        foreach ($arr as $value) {

            $k=1;
            //$html .='<tr><td width="15%"><input type="text" placeholder="" class="form-control head" value="row'.$k.'" disabled=""></td><td> <input type="text" placeholder="" value=';
            foreach($value as $values){
               $newvar = $values['id'];
               if($k == 1)
                   $html .= 'question'.$newvar;
               else
                   $html .= '+question'.$newvar;
               $k++;
            }
           //$html .= " class='form-control formulas'></td></tr>";
        }
        //$html.='</table>';
        return  $html;
    }

   public function get_score(Request $request)
    {
       $q_list = $request->question_list1;
       $t_list = $request->data_testid;

       $questions = explode('+question', $q_list);
       
       $qdata=[];$tdata=[];$qdata1=[];$arr=[];$qdata2=[];
       
       for ($i=1;$i< count($questions);$i++){
            
            //echo $questions[$i];
            $qdata[$i]= DB::table('questions')->select('test_id')->where('id','=',$questions[$i])->get(); 
           $qdata1[]= DB::table('questions')->select('id','test_id','score','questiontype')->where('id','=',$questions[$i])->get();

            //$qdata2[]= DB::table('questions')->select('id','test_id','score')->where('id','=',$questions[$i])->where('questiontype','=','4')->get();

            // $qdata2[$i]= DB::table('questions')->select('id','test_id','score')->where('id','=',$questions[$i])->get();
               
        }

        // print_r($qdata1);
        // die;
      
        if(count($qdata1)!==0){

        foreach ($qdata1 as $key=>$value) {
           
            $arr[$value[0]->test_id][]= array(
                'score'=>$value[0]->score,
            );
        }
        $html = '';
        print_r($arr);
        die;
        $newvar = 0;
        $newvar1 ="";
        $html .= '<table id="real_matrix1" width="100%"><input type="hidden" placeholder="" class="form-control head" value="col2" disabled="" ><tr><td><input type="text" placeholder="" class="form-control empty-cell" value="  " disabled="" ></td>
                                <td><input type="text" placeholder="" class="form-control head" value="col2" disabled="" ></td>
                 </tr>';
        foreach ($arr as $value) {
             $k=1;
           $html .='<tr><td width="15%"><input type="text" placeholder="" class="form-control head" value="row'.$k.'" disabled=""></td><td> <input type="text" placeholder="" value=';
           foreach($value as $values){
            // $newvar = str_replace('[', '', $values['score']);
            // $newvar1 = str_replace(']', '', $newvar);
           $newvar = $this->addTwoNumbers($values['score'], $newvar);
            //$newvar += $values['score'];
              //$k++; 
           }
           $html .= $newvar;
           $html .= " class='form-control formulas'></td></tr>";
        }
        $html.='</table>';
        }
        if(count($qdata2)!==0){
            $qdata2= DB::table('user_answer')->select('question_id','answer')->where('question_id','=',$questions[$i])->get();
            
            print_r($qdata2);
            die;
        }
        return  $html;

        }


		public function addTwoNumbers(int $x, int $y)
		{
			return $x + $y;
		}


    public function get_chart(Request $request)
    { 
       $q_list = $request->question_list1;
       $t_list = $request->data_testid;

       $questions = explode('+question', $q_list);
       
       $qdata=[];$tdata=[];$qdata1=[];$arr=[];$qdata2=[];
       
       for ($i=1;$i< count($questions);$i++){
            
            $qdata[$i]= DB::table('questions')->select('test_id')->where('id','=',$questions[$i])->get(); 
            $qdata1[$i]= DB::table('questions')->select('id','test_id','score')->where('id','=',$questions[$i])->where('questiontype','!=',4)->get();

            $qdata2[$i]= DB::table('questions')->select('id','test_id','score')->where('id','=',$questions[$i])->where('questiontype','=',4)->get();
               
        }

         foreach ($qdata1 as $key=>$value) {
            //print_r($value[0]->score);
            // $structured_results = array('test_id' => $value[$key]->test_id, 'id' => $value[$key]->id);
            $arr[$value[0]->test_id][]= array(
                'score'=>$value[0]->score,
            );
            //   echo '<pre>';
            // print_r($structured_results);
        }
        $html = array();
        //print_r($arr);
        $newvar = '';
        $newvar1 =0;
        $total = 0;
        //$newvar1[0]=0;
        foreach ($arr as $value) {
            
           foreach($value as $values){
                $html= array(4,5,6); 
           }
           
        }
        echo json_encode($html);

    }

    public function show($id)
    {
        if (!Gate::allows('question_view')) {
            return abort(401);
        }
        $questions_options = \App\Models\QuestionsOption::where('question_id', $id)->get();
        $tests = \App\Models\Test::whereHas(
            'questions',
            function ($query) use ($id) {
                $query->where('id', $id);
            }
        )->get();

        $question = Question::findOrFail($id);

        return view('backend.questions.show', compact('question', 'questions_options', 'tests'));
    }


    /**
     * Remove Question from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if (!Gate::allows('question_delete')) {
        //     return abort(401);
        // }        
        DB::table('chart_test')->where('chart_id', $id)->delete();
        DB::table('charts')->where('id', $id)->delete();
        return redirect()->route('admin.charts.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Question at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('question_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Question::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Question from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('question_delete')) {
            return abort(401);
        }
        $question = Question::onlyTrashed()->findOrFail($id);
        $question->restore();

        return redirect()->route('admin.questions.index')->withFlashSuccess(trans('alerts.backend.general.restored'));
    }

    /**
     * Permanently delete Question from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('question_delete')) {
            return abort(401);
        }
        $question = Question::onlyTrashed()->findOrFail($id);
        $question->forceDelete();

        return redirect()->route('admin.questions.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
}
