<?php
use app\util\Html;
use think\facade\Db;
use think\facade\Request;
use think\facade\Session;


// 应用公共文件
function getUrlPath($avatar)
{
    if (!empty($avatar))
    {
        if (!checkUrl($avatar))
        {
            $avatar = str_replace('\\', '/', $avatar);
            return '/storage/' . $avatar;
        }
    }

    return $avatar;
}

/**
 * 返回带协议的域名
 */
function get_domain()
{
    $request = Request::instance();
    return $request->domain();
}


function checkUrl($url){

    $pattern="/^(http|https):\/\/.*$/i";
    
    if(preg_match($pattern,$url)){
        return true;
    }else{
        return false;
    }

}


// //超出展示省略号
// function cutSubstr($str, $len = 16)
// {
//     if (strlen($str) > $len)
//     {
//         $str = mb_substr($str, 0, $len) . '...';
//     }
//     return $str;
// }

function buildConfigHtml($value)
{
    // print_r($value);exit();
    return Html::buildHtml($value);

}

//
function checkAuth($authUrl, $authId = 0)
{
    $root       = Request::root();
    $controller = Request::controller();
    $authUrl    = $authUrl == 'delete' ? 'del' : $authUrl;
    $url        = ltrim(($root . '/' . $controller . '/' . $authUrl), '/');
    // $url        = ltrim(strtolower($root . '/' . $controller . '/' . $authUrl), '/');
    // var_dump($url.'/'.$controller.'/'.$authUrl);exit();

    $Auth     = Session::get('adminAuth');
    $userInfo = json_decode(Session::get('adminUserInfo'), true);
    $role_id  = $userInfo['role_id'];

    if ($role_id === 1)
    {

        return getAdminAuth($authUrl, $url, $authId);
    }

    if (!empty($Auth))
    {

        $AuthArr = explode(',', $Auth);
        $idArr   = DB::name('admin_menu')->field('id')->where(['url' => $url, 'delete_status' => 0])->find();
        if (isset($idArr['id']) && !empty($idArr['id']))
        {

            //
            if (in_array($idArr['id'], $AuthArr))
            {
                return getAdminAuth($authUrl, $url, $authId);
            }
            else
            {
                return '';
            }
        }
    }

    // <!-- <a href="{:checkAuth($Request.root}/{$Request.controller}/add/)}" class="btn btn-success btn-sm btn-add" title="添加">
    //                        <i class="fa fa-plus"></i>
    //                        添加
    //                    </a> -->

    exit();

}

function getAdminAuth($authUrl, $url, $authId)
{

    $config = [
        'add' => [
            'name' => '添加',
            'icon' => 'plus',
        ],
        'edit' => [
            'name' => '编辑',
            'icon' => 'edit',
        ],
        'del' => [
            'name' => '删除',
            'icon' => 'trash',
        ],
        'info' => [
            'name' => '详情',
        ],
    ];

    $class = $authUrl == 'add' ? "btn btn-success btn-sm" : '';
    $url   = $authId ? $url . '/id/' . $authId : $url;

    $result = '<a href=/' . $url . ' class=" ' . $class . ' btn-' . $authUrl . '" title="' . $config[$authUrl]['name'] . '">
                        <i class="fa fa-' . $config[$authUrl]['icon'] . '"></i>
                        ' . $config[$authUrl]['name'] . '
                </a>';

    return $result;

}
