<?php

namespace LambdaDigamma\MMPages\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use LambdaDigamma\MMPages\Traits\SerializeTranslations;

class MenuItem extends Model
{
    use HasFactory;
    use SerializeTranslations;

    public $table = "mm_menu_items";
    protected $guarded = ['*', 'id'];
    public $translatable = ['title'];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

    public function children()
    {
        return $this
            ->hasMany(MenuItem::class, 'parent_id', 'id');
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id', 'id');
    }

    public function scopeRoot(Builder $query)
    {
        return $query->whereNull('parent_id');
    }
}