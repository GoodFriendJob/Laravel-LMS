<?php

namespace App\Http\Controllers\Backend;
use Barryvdh\TranslationManager\Controller as Controller;
use App\Models\Locale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LangController extends Controller
{
    public function postAddLocale(Request $request)
    {
        $locales = $this->manager->getLocales();
        $newLocale = str_replace([], '-', trim($request->input('new-locale')));
        if (!$newLocale || in_array($newLocale, $locales)) {
            $locale_data = Locale::where('short_name', '=', $newLocale)->first();//add ckd
            if (!$locale_data) {
                $locale = new Locale();
                //$long_name = (trans('menus.language-picker.langs.'.$newLocale)) ? trans('menus.language-picker.langs.'.$newLocale) : '';
                //$locale->name = !empty($long_name) ? ucfirst($long_name) : '';
                $locale->short_name = $newLocale;
                $locale->display_type = 'ltr';
                $locale->save();
            }//add ckd
            return redirect()->back();
        }
        $this->manager->addLocale($newLocale);
        $locale_data = Locale::where('short_name', '=', $newLocale)->first();
        if (!$locale_data) {
            $locale = new Locale();
            $locale->short_name = $newLocale;
            $locale->display_type = 'ltr';
            $locale->save();
        }
        return redirect()->back();
    }

    public function postRemoveLocaleFolder(Request $request)
    {
        $locale = $request->delete_locale;
        if($locale){
            Locale::where('short_name', '=', $locale)->delete();
            $this->manager->removeLocale($locale);
            try{

              \Storage::disk('lang')->deleteDirectory($locale);


            }catch (\Exception $e){
                \Log::info($e->getMessage().' - Error while deleting locale "'.$locale.'"');
            }
            return redirect()->back();
        }else{
            abort(404);
        }

    }

}