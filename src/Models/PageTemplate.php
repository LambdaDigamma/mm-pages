<?php

namespace LambdaDigamma\MMPages\Models;

use Illuminate\Database\Eloquent\Model;
use LambdaDigamma\MMPages\Models\Page;
use LambdaDigamma\MMPages\Traits\HasPackageFactory;
use LambdaDigamma\MMPages\Traits\SerializeTranslations;

class PageTemplate extends Model {

    use HasPackageFactory;
    use SerializeTranslations;

    protected $table = "mm_page_templates";
    public $translatable = ['name'];

    public function pages() 
    {
        return $this->hasMany(Page::class, 'page_template_id', 'id');
    }

}