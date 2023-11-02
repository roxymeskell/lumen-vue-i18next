<?php

namespace Database\Seeders;

use App\Models\I18n;
use App\Models\Translation;
use App\Models\Locale;
use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locale = Locale::firstOrCreate(['key' => 'en']);
        $i18n = I18n::firstOrCreate(['key' => 'foo']);
        $trans = new Translation();
        $trans->locale()->associate($locale);
        $trans->i18n()->associate($i18n);
        $trans->content = 'Foo';
        $trans->save();
    }
}
