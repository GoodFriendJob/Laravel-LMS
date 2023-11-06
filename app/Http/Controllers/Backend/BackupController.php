<?php

namespace App\Http\Controllers\Backend;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class BackupController extends Controller
{
    public function index()
    {
        return view('backend.backup.index');
    }

    public function storeBackup(Request $request)
    {
        $this->validate($request, [
            'backup__notifications__mail__to' => 'required|email',
        ]);
        if ($request->get('backup__status') == null) {
            $request['backup__status'] = 0;
        }

        $backupFile = config_path().'/backup.php';

        foreach ($request->all() as $key => $value) {
            if ($key != '_token') {
                $key = str_replace('__', '.', $key);
                $config = \App\Models\Config::firstOrCreate(['key' => $key]);
                $config->value = $value;
                $config->save();
            }
        }

        return back()->withFlashSuccess(__('alerts.backend.general.updated'));
    }


    /**
     * @return mixed
     */
    public function generateBackup()
    {
        if (config('backup.status') == 1) {
            if (config('backup.destination.disks') == 'dropbox') {
                $artisan_command = '';
                switch (config('backup.content')) {
                    case 'db': {
                        $artisan_command = 'backup:run & --only-db';
                        break;
                    }
                    case 'db_storage': {
                        config(['backup.source.files.include' => base_path() . '/storage/app/public']);
                        $artisan_command = 'backup:run';
                        break;
                    }
                    case 'all': {
                        config(['backup.source.files.include' => base_path()]);
                        $artisan_command = 'backup:run';
                        break;
                    }
                }

                $command = explode('&', $artisan_command);
                try {
                    if (count($command) > 1) {
                        \Artisan::call(trim($command[0]), [trim($command[1]) => true]);


                    } else {
                        \Artisan::call(array_first($command));
                    }
                    return back()->withFlashSuccess(__('alerts.backend.general.updated'));

                } catch (\Exception $e) {
                    \Log::info('drop box update failed - ' . $e->getMessage());
                    return back()->withFlashDanger(__('alerts.backend.general.backup_warning'));
                }

            } else if (config('backup.destination.disks') == 's3') {

            }
        }
        return back()->withFlashDanger(__('alerts.backend.general.backup_warning'));

    }

}
