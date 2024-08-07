<?php

namespace LambdaDigamma\MMPages\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use LambdaDigamma\MMPages\Database\Factories\PageFactory;
use LambdaDigamma\MMPages\Traits\SerializeTranslations;
use LaravelArchivable\Archivable;
use LaravelPublishable\Publishable;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use Archivable;
    use HasFactory;
    use HasTranslations;
    use Publishable;
    use SerializeTranslations;
    use SoftDeletes;

    protected $table = 'mm_pages';

    protected $guarded = ['*', 'id'];

    public $translatable = ['title', 'slug', 'summary', 'keywords'];

    public $appends = ['full_slug'];

    public function blocks()
    {
        return $this
            ->hasMany(PageBlock::class)
            ->orderBy('order');
    }

    /**
     * @return void
     */
    public function setAttribute($key, $value)
    {
        if ($key === 'keywords') {
            $this->setTranslation('keywords', app()->getLocale(), $value);
        } else {
            parent::setAttribute($key, $value);
        }
    }

    public function pageTemplate(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PageTemplate::class, 'page_template_id', 'id');
    }

    public function menuItem()
    {
        return $this->hasOne(MenuItem::class, 'page_id', 'id');
    }

    public function parentMenuItem()
    {
        return $this->belongsTo(MenuItem::class, 'parent_menu_item_id', 'id');
    }

    public function getFullSlugAttribute()
    {
        $locale = app()->getLocale();

        return Str::of('/')
            ->append($locale)
            ->append('/')
            ->append($this->slug)
            ->__toString();
    }

    public static function newFactory(): PageFactory
    {
        return PageFactory::new();
    }

    public function scopeFilter($query, array $filters): void
    {
        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');
        $query->when($filters['search'] ?? null, function ($query, $search) use ($locale, $fallback) {
            $query
                ->where("title->${locale}", 'like', '%'.$search.'%')
                ->orWhere("title->${fallback}", 'like', '%'.$search.'%')
                ->orWhere("slug->${locale}", 'like', '%'.$search.'%')
                ->orWhere("slug->${fallback}", 'like', '%'.$search.'%');
        })->when($filters['type'] ?? null, function ($query, $type) {
            if ($type === 'drafts') {
                $query->onlyNotPublished();
            } elseif ($type === 'archived') {
                $query->onlyArchived();
            } elseif ($type === 'deleted') {
                $query->onlyTrashed();
            }
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
