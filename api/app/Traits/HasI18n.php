<?php

namespace App\Traits;

use App\Models\I18n;
use App\Models\Locale;
use App\Models\Translation;
use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Relation;
use LogicException;

trait HasI18n
{
    use UseLocale;

    protected ?string $translationLocale = null;

    // $attributes

    public function getI18nAttributes(): array
    {
        return is_array($this->i18n)
            ? $this->i18n
            : [];
    }

    public function isI18nAttribute(string $key): bool
    {
        return in_array($key, $this->getI18nAttributes());
    }

    public function isI18nRelation(string $key): bool
    {
        return str_ends_with($key, 'I18n') && in_array(str_replace('I18n', '', $key), $this->getI18nAttributes());
    }

    protected function transformToI18nKey($value)
    {
        if (!$this->isI18nAttribute($value) && !$this->isI18nRelation($value))
            throw new Exception(sprintf(
                '%s does not represent an i18n value or relationship', $value
            ));

        return str_replace('I18n', '', $value) . '_i18n_key';
    }

    public function getAttribute($key)
    {
        if (! $key) {
            return;
        }

        // If the attribute exists in the attribute array or has a "get" mutator we will
        // get the attribute's value. Otherwise, we will proceed as if the developers
        // are asking for a relationship's value. This covers both types of values.
        if (array_key_exists($key, $this->attributes) ||
            array_key_exists($key, $this->casts) ||
            $this->hasGetMutator($key) ||
            $this->isClassCastable($key) ||
            $this->isI18nAttribute($key)) {
            return $this->getAttributeValue($key);
        }

        // Here we will determine if the model base class itself contains this given key
        // since we don't want to treat any of those methods as relationships because
        // they are all intended as helper methods and none of these are relations.
        if (method_exists(self::class, $key)) {
            return;
        }

        return $this->getRelationValue($key);
    }

    protected function getAttributeFromArray($key)
    {
        if ($this->isI18nAttribute($key)) {
            if (! is_null( $i18n = $this->{$key . 'I18n'} )) {
                $i18n = $this->{$key . 'I18n'};
                if (! is_null($translation = $i18n->translations->whereRelation('locale', 'key', $this->getLocale())->first()))
                    return $translation->content;
                throw new Exception(sprintf(
                    'Translastion for key `%s` (%s) in locale `%s` not found', $key, $this->{$this->transformToI18nKey($key)}, $this->getLocale()
                ));
            }
            throw new Exception(sprintf('I18n for key `%s` (%s) not found', $key, $this->{$this->transformToI18nKey($key)}));
        }

        return $this->getAttributes()[$key] ?? null;
    }

    // WIP
    // https://github.com/laravel/framework/blob/7.x/src/Illuminate/Database/Eloquent/Concerns/HasAttributes.php#L633
    public function setAttribute($key, $value)
    {
        if ($this->isI18nAttribute($key)) {
            // if (is_null( $i18n = $this->{$key . 'I18n'} ))
            //     $i18n = new I18n([ 'key' => $value ]);
            $i18n = i18n::firstOrCreate(['key' => $this->transformToI18nKey($key)], []);
            $locale = Locale::firstOrCreate(['key' => $this->getLocale()]);
            $i18n->save();
            $locale->save();
            $translation = Translation::whereBelongsTo($i18n)->whereBelongsTo($locale)->firstOrNew([], [ 'i18n_id' => $i18n->id, 'locale_id' => $locale->id ]);
            $translation->i18n_id = $i18n->id;
            $translation->locale_id = $locale->id;
            $translation->content = $value;
            $translation->save();
            $this->{$this->transformToI18nKey($key)} = $i18n->key;
        }

        parent::setAttribute($key, $value);
    }



    public function getRelationValue($key)
    {
        // If the key already exists in the relationships array, it just means the
        // relationship has already been loaded, so we'll just return it out of
        // here because there is no need to query within the relations twice.
        if ($this->relationLoaded($key)) {
            return $this->relations[$key];
        }

        // If the "attribute" exists as a method on the model, we will just assume
        // it is a relationship and will load and return results from the query
        // and hydrate the relationship's value on the "relationships" array.
        if (method_exists($this, $key) ||
            (static::$relationResolvers[get_class($this)][$key] ?? null) ||
            $this->isI18nRelation($key)) {
            return $this->getRelationshipFromMethod($key);
        }
    }

    protected function getRelationshipFromMethod($method)
    {
        if ($this->isI18nRelation($method))
            $relation = $this->belongsTo(I18n::class, $this->transformToI18nKey($method), 'key');
        else
            $relation = $this->$method();

        if (! $relation instanceof Relation) {
            if (is_null($relation)) {
                throw new LogicException(sprintf(
                    '%s::%s must return a relationship instance, but "null" was returned. Was the "return" keyword used?', static::class, $method
                ));
            }

            throw new LogicException(sprintf(
                '%s::%s must return a relationship instance.', static::class, $method
            ));
        }

        return tap($relation->getResults(), function ($results) use ($method) {
            $this->setRelation($method, $results);
        });
    }
}
