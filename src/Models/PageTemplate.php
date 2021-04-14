<?php

namespace LambdaDigamma\MMPages\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LambdaDigamma\MMPages\Database\Factories\PageTemplateFactory;
use LambdaDigamma\MMPages\Traits\SerializeTranslations;

class PageTemplate extends Model
{
    use HasFactory;
    use SerializeTranslations;

    protected $table = "mm_page_templates";
    protected $guarded = ['*', 'id'];
    public $translatable = ['name'];

    public function pages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Page::class, 'page_template_id', 'id');
    }

    public static function newFactory(): PageTemplateFactory
    {
        return PageTemplateFactory::new();
    }
}
