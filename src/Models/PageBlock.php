<?php

namespace LambdaDigamma\MMPages\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LambdaDigamma\MMPages\Database\Factories\PageBlockFactory;
use LambdaDigamma\MMPages\Traits\Hideable;
use LambdaDigamma\MMPages\Traits\SerializeTranslations;

class PageBlock extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SerializeTranslations;
    use Hideable;

    protected $table = "mm_page_blocks";
    protected $guarded = ['*', 'id'];
    protected $casts = [
        'data' => 'array',
    ];

    public $translatable = ['data'];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

    public static function newFactory()
    {
        return PageBlockFactory::new();
    }
}
