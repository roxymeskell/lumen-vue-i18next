<?php

namespace App\Models;

use App\Traits\HasI18n;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes, HasI18n;

    public $table = 'article';
    public $timestamps = true;
    protected $fillable = [
        'title_i18n_key',
        'content_i18n_key',
        'title',
        'content',
    ];
    protected $i18n = ['title', 'content'];
}

// use App\Models\Article
// Article::create(['title' => 'foo', 'content' => 'bar'])
