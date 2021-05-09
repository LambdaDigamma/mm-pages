<?php

namespace LambdaDigamma\MMPages\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use LambdaDigamma\MMPages\Database\Factories\MenuItemFactory;
use LambdaDigamma\MMPages\Traits\SerializeTranslations;

class MenuItem extends Model
{
    use HasFactory;
    use SerializeTranslations;

    public $table = "mm_menu_items";
    protected $guarded = ['*', 'id'];
    public $translatable = ['title', 'fragment'];
    public $with = ["parent"];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

    public function children()
    {
        return $this
            ->hasMany(MenuItem::class, 'parent_id', 'id')
            ->orderBy('order');
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id', 'id');
    }

    public static function newFactory(): MenuItemFactory
    {
        return MenuItemFactory::new();
    }

    public function scopeRoot(Builder $query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeFilter($query, array $filters): void
    {
        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');
        $query->when($filters['search'] ?? null, function ($query, $search) use ($locale, $fallback) {
            $query
                ->where("title->${locale}", 'like', '%'.$search.'%')
                ->orWhere("title->${fallback}", 'like', '%'.$search.'%')
                ->orWhere("fragment->${locale}", 'like', '%'.$search.'%')
                ->orWhere("fragment->${fallback}", 'like', '%'.$search.'%');
        });
    }
}