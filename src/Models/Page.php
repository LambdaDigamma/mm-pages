<?php

namespace LambdaDigamma\MMPages\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LambdaDigamma\MMPages\Database\Factories\PageFactory;
use LambdaDigamma\MMPages\Traits\SerializeTranslations;
use LaravelArchivable\Archivable;

class Page extends Model
{
    use SoftDeletes;
    use HasFactory;
    use SerializeTranslations;
    use Archivable;

    protected $table = "mm_pages";
    protected $guarded = ['*', 'id'];
    public $translatable = ['title', 'slug'];

    public function blocks()
    {
        return $this
            ->hasMany(PageBlock::class, 'page_id', 'id')
            ->orderBy('order');
    }

    public function pageTemplate()
    {
        return $this->belongsTo(PageTemplate::class, 'page_template_id', 'id');
    }

    public static function newFactory()
    {
        return PageFactory::new();
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('title', 'like', '%'.$search.'%');
            $query->where('slug', 'like', '%'.$search.'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
