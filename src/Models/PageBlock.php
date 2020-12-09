<?php 

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use LambdaDigamma\MMPages\Traits\SerializeTranslations;
use Spatie\Translatable\HasTranslations;

class PageBlock extends Model
{
    use SoftDeletes;
    use SerializeTranslations;

    protected $guarded = [];

    protected $casts = [
        'data' => 'array'
    ];

    public $translatable = ['data'];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

}