<?php
namespace tests\softDelete\model;

use framework\db\Model;
use framework\db\softDelete\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Posts extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $table = 'posts';

    protected $fillable = [
        'id',
        'title',
        'body',
        'author_id'
    ];

    /**
     * @return BelongsTo
     * @author tym
     * @date 2021/2/22
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Authors::class);
    }
}
