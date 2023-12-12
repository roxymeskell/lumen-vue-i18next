<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Collection;

class LocaleCollection extends Collection
{
    public function setLocale(string $locale)
    {
        return $this->map(fn ($model) => $model->setLocale($locale));
    }
}
