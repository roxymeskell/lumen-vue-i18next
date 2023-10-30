<?php

namespace App\Models;

use App\Models\I18n;
use App\Models\Locale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Translation extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = [
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
}
