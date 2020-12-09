<?php 

namespace LambdaDigamma\MMPages\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LambdaDigamma\MMPages\Traits\HasPackageFactory;
use LambdaDigamma\MMPages\Traits\SerializeTranslations;

class PageBlock extends Model
{
    use HasPackageFactory;
    use SoftDeletes;
    use SerializeTranslations;

    protected $table = "mm_page_blocks";
    protected $guarded = ['*', 'id'];
    protected $casts = [
        'data' => 'array'
    ];

    public $translatable = ['data'];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

}