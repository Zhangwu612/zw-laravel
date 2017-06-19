<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Member\Profile;
use Illuminate\Support\Facades\DB;

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

    /**
     * 数据库查询 facade 模式
     */
    public function facade()
    {
        $bool = DB::insert("insert into member (name,age,phone)values(?,?,?)",['cat'.rand(1,1000),10,'15168293252']);
        $num = DB::update('update member set age=?,name=? where id <5',[12,'dog']);
        $array = DB::select("select * from member order by id desc limit 10");

        echo "<pre>";
        var_dump($bool);
        var_dump($num);
        var_dump($array);
    }


    /**
     * 使用laravel 封装的查询构造器
     */
    public function insert()
    {
        //插入一条数据
        $bool = DB::table('member')->insert(['name'=>'crow','age'=>3]);
        //插入一条数据并返回插入ID
        $insert_id = DB::table('member')->insertGetId(['name'=>'crow','age'=>3]);
        //插入多条
        $bool_muti = DB::table('member')->insert([
            ['name'=>'crow','age'=>3],
            ['name'=>'crow5','age'=>5],
            ['name'=>'crow6','age'=>6],
        ]);

        echo "<pre>";
        var_dump($bool);
        var_dump($bool_muti);
        var_dump($insert_id);

    }

    /**
     * 更新
     */
    public function update()
    {

        //更新ID=5的这条数据 name 改为pig ,返回影响行数
        $num = DB::table('member')->where('id','5')->update(['name'=>'pig']);
        //将表中age 字段的值全部自增3
        $num2 = DB::table('member')->increment('age',3);
        //将id=1的所有age 自增3
        $num3 = DB::table('member')->where('id',1)->increment('age',3);
        //将id=1的所有age 自减3
        $num4 = DB::table('member')->where('id',1)->decrement('age',3);
        //将id=1的所有age 自减3 ,并且更新字段name = hello
        $num5 = DB::table('member')->where('id',1)->decrement('age',3,['name'=>'hello']);


        echo "<pre>";
        var_dump($num);
        var_dump($num2);
        var_dump($num3);

    }

    /**
     * 删除
     */
    public function delete()
    {
        //将ID<=3的数据删除,返回影响行数
        $num = DB::table('member')->where('id','<=',3)->delete();
    }

    /**
     * 查询
     */

    public function query()
    {
        echo '<pre>';
        //查询所有 多条
        $array = DB::table('member')->get();
        //select 指定 ID，name 字段
        $array = DB::table('member')->select('id','name')->get();
        //查询一条
        $object = DB::table('member')->first();
        //查询ID>1的按照ID倒序第一条
        $array2 = DB::table('member')
            ->where('id','>',1)
            ->orderBy('id','desc')
            ->get();
        //复杂条件 id >1 and id <100
        $object3 = DB::table('member')
            ->whereRaw('id > ? and id < ?',[1,100])
            ->orderBy('id','desc')
            ->first();


        //pluck 查询 某个字段的值的集合
        $array_pluck = DB::table('member')->where('id','>',1)->pluck('name');
        //echo $array_pluck[0];
        //var_dump($array_pluck);



        /** lists 方法使用失败 **/
        //lists 查询 某个字段的值的集合 ,可以指定哪个字段的值为下标
        //返回集合数组，以id为键name为值的数组
        //$array_lists = DB::table('member')->lists('name','id');
        //var_dump($array_lists);


        //chunk
        // 每次查询2条,可根据条件终止查询，必须要加上排序
        DB::table('member')->orderBy('id','desc')->chunk(2,function($res){
            var_dump($res);
            //终止查询
            if(0==1){
                return false;
            }
        });

        //查询最大值
        DB::table('member')->max('age');
        //最小值
        DB::table('member')->min('age');
        //平均值
        DB::table('member')->avg('age');
        //求和
        DB::table('member')->sum('age');

    }

    public function orm()
    {

        $lists = Profile::all();
        Profile::find(100);
        Profile::where('id',1)->orderBy('id','desc')->first();

        //插入数据
        $profile = new Profile();
        $profile->name = 'ddasda';
        $profile->age = '100';
        $profile->save();
        //修改数据
        $data = $profile->find(1000);
        $data->name='updateeee';
        $data->save();

        //删除
        Profile::where('id',1)->delete();
        //删除id=100
        Profile::destroy(100);
        Profile::destroy([100,200]);

    }

}
