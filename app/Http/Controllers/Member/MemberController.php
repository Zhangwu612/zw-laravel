<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Member\Profile;

/** 测试控制器
 * Class MemberController
 * @package App\Http\Controllers\Member
 */
class MemberController extends Controller
{
    public function profile($uid=null)
    {
        //根据设定的路由别名取到当前的url
        $url = Route('member-profile',['uid'=>$uid]);
        //调用模型
        $username = Profile::getUserName();
        //渲染的变量
        $assign = [
            'url'=>$url,
            'uid'=>$uid,
            'name'=>'hello world',
            'username'=>$username
        ];
        //渲染视图  /resources/views/member/profile.blade.php
        return view('member/profile',$assign);
    }
}
