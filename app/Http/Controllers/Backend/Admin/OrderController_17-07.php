<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Helpers\General\EarningHelper;
use App\Models\Bundle;
use App\Models\Course;
use App\Models\Order;
use App\Models\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;


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
                    ->with(['route' => route('admin.orders.show', ['order' => $q->id])])->render();

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
                        $items .= $key . '. ' . $item->item->title . "<br>";
                    }

                }
                return $items;
            })
            ->addColumn('user_email', function ($q) {
                return $q->user->email;
            })
            ->addColumn('date', function ($q) {
                return $q->updated_at->diffforhumans();
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


}
