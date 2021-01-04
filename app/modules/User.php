<?php
/**
 * This file is part of Monda-PHP.
 *
 */

namespace app\modules;


use framework\db\Model;

/**
 * Class User
 * @property mixed is_super_admin
 * @property mixed id
 * @property mixed name
 * @property mixed password
 * @property mixed number
 * @property mixed is_confirm_password
 * @property mixed is_deny
 * @property mixed email
 * @package model\entity\admin
 * @author chenzifan
 * @date 2020/2/6
 */
class User extends Model
{
    protected $table = 'admin_user';
    protected $connection = 'default';

    protected $fillable = [
        'id',
        'password',
        'number',
        'name',
        'oa_department',
        'last_ip',
        'reg_ip',
        'login_count',
        'last_time',
        'is_deny',
        'is_super_admin',
        'structure_id',
        'email',
        'is_follow',
        'tel_phone',
        'phone',
        'call_account',
        'is_confirm_password',
        'sign_img',
    ];
}
