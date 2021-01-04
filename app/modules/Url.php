<?php

namespace app\modules;

use framework\db\Model;

class Url extends Model
{
    public $incrementing = false;
    protected $connection = 'bi';
    protected $table = 'bi_url';

    protected $fillable = [
        'id',
        'project_id',
        'name',
        'logo',
        'url',
        'sort',
        'create_user_id',
        'is_workbench'
    ];
}
