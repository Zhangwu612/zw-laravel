<?php
namespace App\Member;
use Illuminate\Database\Eloquent\Model;

/**
 * 模型 test
 * Class Profile
 * @package App
 */
class Profile extends Model
{
    //指定表名
    protected $table = 'member';
    //指定主键
    protected $primaryKey = 'id';

    public static function getUserName()
    {
        return 'hhh';
    }
}

