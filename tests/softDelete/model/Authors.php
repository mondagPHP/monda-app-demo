<?php

namespace tests\softDelete\model;


use framework\db\Model;
use framework\db\softDelete\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Authors extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $table = 'authors';

    protected $fillable = [
        'id',
        'name',
    ];

    /**
     * @return HasMany
     * @author tym
     * @date 2021/2/22
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Posts::class);
    }
}

