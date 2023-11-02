<?php

namespace App\Http\Controllers;

use App\Models\I18n;

class I18nController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function get($key)
    {
        $locale = 'en';
        $i18n = I18n::where('key', '=', $key)->firstOrFail();
        // $translation = $i18n->translations()->with('locale')->where('locale', $locale)->first();
        // $translation = $i18n->translations()->with('locale')->first();

        $translation = $i18n->translations()->whereHas('locale', function ($query) use ($locale) {
            $query->where('key','=', $locale);
        })->first();

        // $translation = $i18n->translations()->with(['locale' => function ($query) use ($locale) {
        //     $query->where('key','=', $locale);
        // }])->first();

        \Illuminate\Support\Facades\Log::info('Getting translation ' . json_encode($translation));

        return $translation;
        /// return I18n::findOrFail($key);
    }


}
