<?php
declare (strict_types = 1);
namespace app;

use app\BaseController;
use think\facade\DB;
use think\facade\View;
use think\facade\Env;
use app\util\Nav;
use app\util\Tools;
use think\exception\HttpResponseException;



class WebBaseController extends BaseController
{

    protected $layout = 'default';

    protected $template;

    // 初始化
    protected function initialize()
    {
        //获取当前配置的模板
        $this->getWebTheme();
        View::assign('nav', $this->getNav());
        View::assign('templateName', $this->template);
    }

    /**
     * [getWebTheme 获取当前配置的模板]
     */
    public function getWebTheme()
    {
        $res = DB::name('user')->find();
        if ($res)
        {
            $path = WEB_ROOT . '/' . config('view.view_dir_name') . '/web/' . '/default/';
        }
        else
        {
            $path = WEB_ROOT . '/' . config('view.view_dir_name') . '/web/' . '/default/';
        }
        if (Env::get('DEV.RUNTIME') == 'develop')
        {

            $this->template = '/lte/'.app('http')->getName().'/';
            
            $path           = WEB_ROOT . '/' . config('view.view_dir_name') . '/web/' . '/lte/'.app('http')->getName().'/';
        }
        
        View::config(['view_path' => $path]);

    }

    public function getNav()
    {

        $access = DB::name('course_category')
            ->where('show_status', 1)
            ->where('delete_status', 0)
            ->order('sort', 'asc')
            ->select()->toArray();

        // print_r($access);exit();

        //组装选中状态

         $nav = Nav::buildNav(
            Tools::listToTree($access, 'id', 'parent_id')
        );
        return $nav;        


    }


            /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param  mixed     $msg 提示信息
     * @param  string    $url 跳转的URL地址
     * @param  mixed     $data 返回的数据
     * @param  integer   $wait 跳转等待时间
     * @param  array     $header 发送的Header信息
     * @return void
     */
    protected function success($msg = '', string $url = null, $data = '', int $wait = 3, array $header = [])
    {
        if (is_null($url) && isset($_SERVER["HTTP_REFERER"])) {
            $url = $_SERVER["HTTP_REFERER"];
        } elseif ($url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : app('route')->buildUrl($url);
        }

        $result = [
            'code' => 1,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        $type = $this->getResponseType();
        if ($type == 'html'){
            $response = view($this->app->config->get('app.dispatch_success_tmpl'), $result);
        } else if ($type == 'json') {
            $response = json($result);
        }
        throw new HttpResponseException($response);
    }

    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param  mixed     $msg 提示信息
     * @param  string    $url 跳转的URL地址
     * @param  mixed     $data 返回的数据
     * @param  integer   $wait 跳转等待时间
     * @param  array     $header 发送的Header信息
     * @return void
     */
    protected function error($msg = '', string $url = null, $data = '', int $wait = 3, array $header = [])
    {
        if (is_null($url)) {
            $url = $this->request->isAjax() ? '' : 'javascript:history.back(-1);';
        } elseif ($url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : $this->app->route->buildUrl($url);
        }

        $result = [
            'code' => 0,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        $type = $this->getResponseType();
        if ($type == 'html'){
            $response = view($this->app->config->get('app.dispatch_error_tmpl'), $result);
        } else if ($type == 'json') {
            $response = json($result);
        }
        throw new HttpResponseException($response);
    }

    /**
     * URL重定向  自带重定向无效
     * @access protected
     * @param  string         $url 跳转的URL表达式
     * @param  array|integer  $params 其它URL参数
     * @param  integer        $code http code
     * @param  array          $with 隐式传参
     * @return void
     */
    protected function redirect($url, $params = [], $code = 302, $with = [])
    {
        $response = Response::create($url, 'redirect');

        if (is_integer($params)) {
            $code   = $params;
            $params = [];
        }

        $response->code($code)->params($params)->with($with);

        throw new HttpResponseException($response);
    }

    /**
     * 获取当前的response 输出类型
     * @access protected
     * @return string
     */
    protected function getResponseType()
    {
        return $this->request->isJson() || $this->request->isAjax() ? 'json' : 'html';
    }


}
