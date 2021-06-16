<?php

namespace LambdaDigamma\MMPages\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LambdaDigamma\MMPages\Database\Factories\PageBlockFactory;
use LambdaDigamma\MMPages\Traits\Hideable;
use LambdaDigamma\MMPages\Traits\SerializeTranslations;
use LaravelPublishable\Expirable;
use LaravelPublishable\Publishable;

class PageBlock extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SerializeTranslations;
    use Hideable;
    use Publishable;
    use Expirable;

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    // protected $touches = ['page'];

    protected $table = "mm_page_blocks";
    protected $guarded = ['*', 'id'];
    protected $casts = [
        'data' => 'array',
    ];
    protected $with = ['children'];
    
    public $translatable = ['data'];

    public function page(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

    public function children()
    {
        return $this
            ->hasMany(PageBlock::class, 'parent_id', 'id')
            ->orderBy('order');
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PageBlock::class, 'parent_id', 'id');
    }

    public static function newFactory(): PageBlockFactory
    {
        return PageBlockFactory::new();
    }
}
