<?php

namespace App\Http\Controllers;

use App\Models\Locale;
use Illuminate\Support\Facades\App;

/**
 * Class LanguageController.
 */
class LanguageController extends Controller
{
    /**
     * @param $locale
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function swap($locale)
    {
        $locales = Locale::get();
        $locales_list = $locales->pluck('short_name')->toArray();

        if (in_array($locale, $locales_list)) {
            $locale_data =      $locales->where('short_name','=',$locale)->first();
            request()->session()->put('locale', $locale);
            request()->session()->put('display_type', $locale_data->display_type);

        }
        return redirect()->back();
    }
}
