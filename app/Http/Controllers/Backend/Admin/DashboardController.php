<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Requests;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function CKEditorFileUpload(Request $request){
        if(isset($_FILES['upload']['name'])){
            $file = $_FILES['upload']['tmp_name'];
            $file_name = $_FILES['upload']['name'];
            $file_name_array = explode(".", $file_name);
            $extension = end($file_name_array);
            $new_image_name = $file_name_array[0].rand().'.'.$extension;
            chmod('uploads/image/', 0777);
            $allowed_extention = array("jpg", "gif", "png");
            if(in_array($extension, $allowed_extention)){
                move_uploaded_file($file, 'uploads/image/'.$new_image_name);
                $function_number = $_GET['CKEditorFuncNum'];
                $url = $_SERVER['HTTP_ORIGIN'].'/uploads/image/'.$new_image_name;
                $message = '';
                echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";
            }
        }

    }
}
