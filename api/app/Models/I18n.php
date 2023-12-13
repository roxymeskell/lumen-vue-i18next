<?php

namespace App\Models;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class I18n extends Model
{
    use SoftDeletes;

    public $table = 'i18n';
    public $timestamps = true;
    protected $fillable = [
        'key',
    ];

    // One-to-Many relationship with translation
    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class);
    }

    public function locales(): HasManyThrough
    {
        return $this->hasManyThrough(Translation::class, Locale::class);
    }
}
