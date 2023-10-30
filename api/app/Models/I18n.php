<?php

namespace App\Models;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class I18n extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = [
        'key',
    ];

    // One-to-Many relationship with translation
    public function translation(): HasMany
    {
        return $this->hasMany(Translation::class);
    }
}
