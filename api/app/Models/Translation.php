<?php

namespace App\Models;
// Translation::whereBelongsTo($i18n)
use App\Models\I18n;
use App\Models\Locale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


// Use composite primary key:
// https://github.com/thiagoprz/eloquent-composite-key/blob/master/src/HasCompositeKey.php
// https://medium.com/@przyczynski/laravel-working-with-composite-keys-8c4b282f5523

class Translation extends Model
{
    use SoftDeletes;

    public $table = 'translation';
    public $timestamps = true;
    protected $fillable = [
        'i18n_id',
        'locale_id',
        'content',
    ];

        // One-to-Many relationship with i18n
        public function i18n(): BelongsTo
        {
            return $this->belongsTo(I18n::class);
        }

        // One-to-Many relationship with locale
        public function locale(): BelongsTo
        {
            return $this->belongsTo(Locale::class);
        }

        // https://github.com/laravel/framework/blob/8.x/src/Illuminate/Database/Eloquent/Builder.php#L488
        // https://github.com/laravel/framework/blob/8.x/src/Illuminate/Database/Eloquent/Concerns/QueriesRelationships.php#L471
        // $i18n = I18n::where('key', $key)->firstOrFail();
        // $locale = Locale::where('key', $locale)->firstOrFail();
        // $translation = Translation::whereBelongsTo($i18n)->whereBelongsTo($locale)->get();
}
