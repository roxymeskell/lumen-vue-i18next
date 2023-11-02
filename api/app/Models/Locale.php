<?php

namespace App\Models;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Locale extends Model
{
    use SoftDeletes;

    public $table = 'locale';
    public $timestamps = true;
    protected $fillable = [
        'key',
    ];

    // One-to-Many relationship with translation
    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class);
    }
}
