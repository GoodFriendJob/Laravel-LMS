<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    public function destroy(Request $request){
        $media_id =  $request->media_id;
        $media = Media::find($media_id);

        if($media){
            //Delete Related data
            $filename = $media->file_name;

            $media->delete();

            //Delete Photo
            $destinationPath = public_path() . '/storage/uploads/'.$filename;
            if (file_exists($destinationPath)) {
                unlink($destinationPath);
            }
            return response()->json(['success'=>'Deleted Successfully']);
        }else{
            return response()->json(['failure'=>'No Gallery']);
        }
    }
}
