<?php
use app\util\Html;
use think\facade\Db;
use think\facade\Request;
use think\facade\Session;

// 应用公共文件
function getUrlPath($url)
{
    if (!empty($url))
    {
        if (!checkUrl($url))
        {
            $url = str_replace('\\', '/', $url);
            return '/storage/' . $url;
        }
    }

    return $url;
}

/**
 * 返回带协议的域名
 */
function getDomain()
{
    $request = Request::instance();
    return $request->domain();
}

function checkUrl($url)
{

    $pattern = "/^(http|https):\/\/.*$/i";

    if (preg_match($pattern, $url))
    {
        return true;
    }
    else
    {
        return false;
    }

}

function fixUrl($url, $def = false, $prefix = false)
{

    $url = trim($url);
    if (empty($url))
    {
        return $def;
    }
    if (count(explode('://', $url)) > 1)
    {
        return $url;
    }
    else
    {
        return $prefix === false ? 'http://' . $url : $prefix . $url;
    }
}

function buildConfigHtml($value)
{
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
    $class = $authUrl == 'del' ? 'btn-dialog' : $class;
    $url   = $authId ? $url . '/id/' . $authId : $url;

    $result = '<a href=/' . $url . ' class=" ' . $class . ' btn-' . $authUrl . '" title="' . $config[$authUrl]['name'] . '" data-msg="' . $config[$authUrl]['name'] . '">
                        <i class="fa fa-' . $config[$authUrl]['icon'] . '"></i>
                        ' . $config[$authUrl]['name'] . '
                </a>';

    return $result;

}

/**
 * 检查手机格式，中国手机不带国家代码，国际手机号格式为：国家代码-手机号
 * @param $mobile
 * @return bool
 */
function checkMobile($mobile)
{
    if (preg_match('/(^(13\d|14\d|15\d|16\d|17\d|18\d|19\d)\d{8})$/', $mobile))
    {
        return true;
    }
    else
    {
        if (preg_match('/^\d{1,4}-\d{5,11}$/', $mobile))
        {
            if (preg_match('/^\d{1,4}-0+/', $mobile))
            {
                //不能以0开头
                return false;
            }

            return true;
        }

        return false;
    }
}

function getRoundCode($length = 6)
{

    switch ($length)
    {
        case 4:
            $result = rand(1000, 9999);
            break;
        case 6:
            $result = rand(100000, 999999);
            break;
        case 8:
            $result = rand(10000000, 99999999);
            break;
        default:
            $result = rand(100000, 999999);
    }
    return $result;

}

function getUserInfoData($admin = 0, $column = 'id')
{
    $key      = $admin ? 'adminUserInfo' : 'UserInfo';
    $userInfo = Session::get($key);
    if (!empty($userInfo))
    {
        $info = json_decode($userInfo, true);
        return $info[$column];
    }
    else
    {
        return false;
    }
}

//获取用户头像
function getUserAvatarUrl()
{
    return getUrlPath(getUserInfoData(0, 'avatar_url'));
}

function getTemplate($name)
{

    $templateDir = config('view.view_dir_name');

    $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . '../' . $templateDir . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR;
    $dir = str_replace('\\', '/', $dir);

    if (is_dir($dir))
    {
        return array_slice(scandir($dir), 2);
    }

    return ['default'];
}

function splitSql($file, $tablePre, $charset = 'utf8mb4', $defaultTablePre = 'edu_', $defaultCharset = 'utf8mb4')
{
    if (file_exists($file))
    {
        //读取SQL文件
        $sql = file_get_contents($file);
        $sql = str_replace("\r", "\n", $sql);
        $sql = str_replace("BEGIN;\n", '', $sql); //兼容 navicat 导出的 insert 语句
        $sql = str_replace("COMMIT;\n", '', $sql); //兼容 navicat 导出的 insert 语句
        $sql = str_replace($defaultCharset, $charset, $sql);
        $sql = trim($sql);
        //替换表前缀
        $sql  = str_replace(" `{$defaultTablePre}", " `{$tablePre}", $sql);
        $sqls = explode(";\n", $sql);
        return $sqls;
    }

    return [];
}

/**
 * 上传路径转化,默认路径
 * @param $path
 * @param int $type
 * @param bool $force
 * @return string
 */
function makePath($path, int $type = 2, bool $force = false)
{
    $path = DIRECTORY_SEPARATOR . ltrim(rtrim($path));
    // switch ($type)
    // {
    //     case 1:
    //         $path .= DIRECTORY_SEPARATOR . date('Y');
    //         break;
    //     case 2:
    //         $path .= DIRECTORY_SEPARATOR . date('Y') . DIRECTORY_SEPARATOR . date('m');
    //         break;
    //     case 3:
    //         $path .= DIRECTORY_SEPARATOR . date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . date('d');
    //         break;
    // }
    try {
        if (is_dir(app()->getRootPath() . 'public' . DIRECTORY_SEPARATOR . 'storage' . $path) == true || mkdir(app()->getRootPath() . 'public' . DIRECTORY_SEPARATOR . 'storage' . $path, 0777, true) == true)
        {
            return trim(str_replace(DIRECTORY_SEPARATOR, '/', $path), '.');
        }
        else
        {
            return '';
        }

    }
    catch (\Exception $e)
    {
        if ($force)
        {
            throw new \Exception($e->getMessage());
        }

        return '无法创建文件夹，请检查您的上传目录权限：' . app()->getRootPath() . 'public' . DIRECTORY_SEPARATOR . 'uploaDIRECTORY_SEPARATOR' . DIRECTORY_SEPARATOR . 'attach' . DIRECTORY_SEPARATOR;
    }

}
