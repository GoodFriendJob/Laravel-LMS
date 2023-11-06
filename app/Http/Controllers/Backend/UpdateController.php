<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Madnest\Madzipper\Madzipper;

class UpdateController extends Controller
{
    public function index()
    {
        return view('backend.update.index');
    }

    public function listFiles(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:zip'
        ]);
        $file = $request->file('file');
        $file_name = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path() . '/updates/', $file_name);
        $is_verified = false;
        $zipper = new Madzipper();
        $checkFiles = $zipper->make(public_path() . '/updates/' . $file_name)->listFiles();
        foreach ($checkFiles as $item) {
            $item = Arr::last(explode('/', $item));
            if ($item == md5('NeonLMSUpdate') . '.key') {
                $is_verified = true;
            }
        }
        if ($is_verified == true) {
            $zipper = new Madzipper();
            $files = $zipper->make(public_path() . '/updates/' . $file_name)->listFiles();
            return view('backend.update.file-list', compact('files', 'file_name'));
        } else {
            unlink(public_path() . '/updates/' . $file_name);
            return redirect(route('admin.update-theme'))->withFlashDanger(__('alerts.backend.general.unverified'));
        }

    }

    public function updateTheme(Request $request)
    {
        ini_set('max_execution_time', 1000);
        ini_set('memory_limit', '-1');

        $file_name = $request->file_name;
        if ($request->submit == 'cancel') {
            unlink(public_path() . '/updates/' . $file_name);
            return redirect(route('admin.update-theme'))->withFlashDanger(__('alerts.backend.general.cancelled'));
        } else {

            try{
                $zipper = new Madzipper();
                $zipper->make(public_path() . '/updates/' . $file_name)->extractTo(base_path());
                unlink(public_path() . '/updates/' . $file_name);


                Artisan::call("config:clear");
//                Artisan::call("migrate");
                exec('cd ' . base_path() . '/ && composer install');


                exec('cd ' . base_path() . '/ && composer du');

                unlink(base_path() . '/bootstrap/cache/packages.php');
                unlink(base_path() . '/bootstrap/cache/services.php');


                return redirect(route('admin.update-theme'))->withFlashSuccess(__('alerts.backend.general.updated'));
            }catch (\Exception $e){
                return redirect(route('admin.update-theme'))->withFlashSuccess('Error updating script. '.$e->getMessage());
            }


        }
    }

    public function deleteFiles(){
        $dir = base_path('vendor/paypal');
        $this->unlinkAllFiles($dir);

        $dir = base_path('vendor/stripe');
        $this->unlinkAllFiles($dir);

    }

    public function unlinkAllFiles($str)
    {
        // Check for files
        if (is_file($str)) {

            // If it is file then remove by
            // using unlink function
            return unlink($str);
        } // If it is a directory.
        elseif (is_dir($str)) {

            // Get the list of the files in this
            // directory
            $scan = glob(rtrim($str, '/') . '/*');

            // Loop through the list of files
            foreach ($scan as $index => $path) {

                // Call recursive function
                $this->unlinkAllFiles($path);
            }

            // Remove the directory itself
            return @rmdir($str);
        }
        return true;
    }
}
