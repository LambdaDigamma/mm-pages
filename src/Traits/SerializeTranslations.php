<?php

namespace LambdaDigamma\MMPages\Traits;

use Spatie\Translatable\HasTranslations;

trait SerializeTranslations
{
    use HasTranslations;

    public function isTranslatableAttribute(string $key): bool
    {
        return in_array($key, $this->getTranslatableAttributes()) && ! in_array($key, $this->not_translatable ?? []);
    }

    public function toArray()
    {
        $attributes = parent::toArray();

        foreach ($this->getTranslatableAttributes() as $name) {
            $attributes[$name] = $this->getTranslation($name, app()->getLocale());
        }

        return $attributes;
    }
}
