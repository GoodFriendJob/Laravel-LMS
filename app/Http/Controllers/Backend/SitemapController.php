<?php

namespace App\Http\Controllers\Backend;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SitemapController extends Controller
{
    public function getIndex(){
        return view('backend.sitemap.index');
    }

    public function saveSitemapConfig(Request $request){

        $this->validate($request, [
            'sitemap__schedule' => 'required',
        ]);
        if ($request->get('sitemap__chunk') == null) {
            $request['sitemap__chunk'] = 100;
        }

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

    public function generateSitemap(){
        ini_set('memory_limit', '-1');
        unlink(base_path() . '/bootstrap/cache/packages.php');
        unlink(base_path() . '/bootstrap/cache/services.php');
        $chunk = (config('sitemap.chunk') ? config('sitemap.chunk') : 100);
        \Illuminate\Support\Facades\Artisan::call('generate:sitemap', ['--chunk' => $chunk]);
        return back()->withFlashSuccess(trans('labels.backend.sitemap.generated'));
    }
}
