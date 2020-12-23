<?php
namespace app\api\controller\admin;

use app\AdminApiBaseController;
use think\facade\View;

class Auth extends AdminApiBaseController
{
    // protected $middleware = ['adminAuthApi','AccessApi'];

    public function Login()
    {
        $str = '{"user":{"user":{"createBy":null,"updatedBy":"admin","createTime":1534986716000,"updateTime":1599273811000,"id":1,"roles":[{"id":1,"name":"超级管理员","level":1,"dataScope":"全部"}],"jobs":[{"id":11,"name":"全栈开发"}],"dept":{"id":2,"name":"研发部"},"deptId":null,"username":"admin","nickName":"管理员","email":"admin@el-admin.vip","phone":"18888888888","gender":"男","avatarName":"avatar.jpeg","avatarPath":"/home/eladmin/avatar/avatar.jpeg","enabled":true,"pwdResetTime":1588495111000},"dataScopes":[],"roles":["admin"]},"token":"Bearer eyJhbGciOiJIUzUxMiJ9.eyJqdGkiOiJkZmQ1OTk2MTBjYTM0Zjg3YWRiOWQzMjM3NmQ0NTVhMiIsImF1dGgiOiJhZG1pbiIsInN1YiI6ImFkbWluIn0.mLXCAWRxQP9QlOVS5ps3JK2Owx_hcWHz38AgCD8Agauqbait_FHrJQP9DaHjq8JWxIhMXfHGzyshJyhTc8HC0A"}';

    	return json(json_decode($str,true));
    }

    //
    public function info()
    {
        $str = '{"user":{"createBy":null,"updatedBy":"admin","createTime":1534986716000,"updateTime":1599273811000,"id":1,"roles":[{"id":1,"name":"超级管理员","level":1,"dataScope":"全部"}],"jobs":[{"id":11,"name":"全栈开发"}],"dept":{"id":2,"name":"研发部"},"deptId":null,"username":"admin","nickName":"管理员","email":"admin@el-admin.vip","phone":"18888888888","gender":"男","avatarName":"avatar.jpeg","avatarPath":"/home/eladmin/avatar/avatar.jpeg","enabled":true,"pwdResetTime":1588495111000},"dataScopes":[],"roles":["admin"]}';

        return json(json_decode($str,true));
    }

}
