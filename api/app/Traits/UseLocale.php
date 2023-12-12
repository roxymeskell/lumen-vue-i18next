<?php

namespace App\Traits;


use App\Support\LocaleCollection;
use Illuminate\Database\Eloquent\Collection;

/**
 * Trait to help manage locale and translations for models
 *
 * Example of use when getting content:
 *
 *   public function nameContent(): BelongsTo
 *   {
 *       return $this->belongsTo(Content::class, 'name_content_key', 'key')
 *                   ->withDefault([ 'value' => null ]);
 *   }
 *
 *   public function getNameAttribute()
 *   {
 *       $content = $this->nameContent;
 *       $translation = $content->{Content::getColumnName($this->getLocale())} ?: $content->value;
 *       return $translation;
 *   }
 *
 *   public function setNameAttribute($value)
 *   {
 *       $contentValColName = Content::getColumnName($this->getLocale());
 *       $content = Content::firstOrNew( [ $contentValColName => $value, ] );
 *       if (!$content->key) $content->key = $content->createKey();
 *       $this->nameContent()->associate($content);
 *   }
 */
trait UseLocale
{
    protected ?string $translationLocale = null;

    public static function usingLocale(string $locale): self
    {
      return (new self())->setLocale($locale);
    }

    public function setLocale(string $locale): self
    {
      $this->translationLocale = $locale;
      return $this;
    }

    public function getLocale(): string
    {
      return $this->translationLocale ?: config('app.locale');
    }

    public function newCollection(array $models = []): Collection
    {
        return new LocaleCollection($models);
    }
}
