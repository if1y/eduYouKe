<?php
declare (strict_types = 1);
namespace app;
use think\facade\View;
use think\facade\DB;
use app\BaseController;
use think\facade\Env;
use app\util\Tools;
use think\facade\Request;


class AdminBaseController extends BaseController{

    //模板继承
    protected $layout = 'default';

    // 初始化
    protected function initialize()
    {
        //获取当前配置的模板
        $this->getWebTheme();
        View::assign('adminMenus', $this->getMenus());
        //模板继承
        if ($this->layout) {
            View::layout('layout/' . $this->layout);
        }
    }

    /**
     * [getWebTheme 获取当前配置的模板]
     */
    public function getWebTheme()
    {
        $res = DB::name('user')->find();
        if($res){
            $path = WEB_ROOT.'/'.config('view.view_dir_name').'/'.app('http')->getName().$this->layout;
        }else{
            $path = WEB_ROOT.'/'.config('view.view_dir_name').'/'.app('http')->getName().$this->layout;
        }
        if (Env::get('DEV.RUNTIME') == 'develop') {
            $path = WEB_ROOT.'/'.config('view.view_dir_name').'/'.app('http')->getName().'/adminlte/';
            
        }
        // define('STATIC_PATH', WEB_ROOT . 'public/static');
        View::config(['view_path' =>$path]);

    }


    final public function getMenus()
    {   
        

        $access = DB::name('admin_menu')
        ->where('status',1)
        ->order('list_order','desc')
        ->select()->toArray();


        

        $access = $this->getActiveStatus($access);

        // if ($type)
        // {
        //     $roleObj = new AdminRole();
        //     $adminRoleResult = $userInfo['module_id'];
        //     // $adminRoleResult = cache('adminRoleResult:' . $userInfo['id']);
        //     $adminRoleResult = explode(',', str_replace("，", ",", $adminRoleResult));

        //     foreach ($access as $key => $value)
        //     {
        //         $value['auth'] = in_array($value['id'], $adminRoleResult) ? 1 : 0;
        //         $access[$key]  = $value;
        //     }
        // }
        $menus = Tools::listToTree($access, 'id', 'parent_id',);
        // $formatTree = Tools::formatTree($menus);

        // print_r($menus);exit();
        // print_r($formatTree);exit();


        return $menus;
    }

    /**
     * [getActiveStatus 获取选中状态]
     * @Author   HUI
     * @DateTime 2020-02-08
     * @version  [version]
     * @param    [type]     $access [description]
     * @return   [type]             [description]
     */
    public function getActiveStatus($access)
    {

        $app = strtolower(app('http')->getName());
        $controller = strtolower(Request::controller());
        $action = strtolower(Request::action());
        $active = $app.'/'.$controller.'/'.$action;

        foreach ($access as $key => $v) {
            $val = $v['app'].'/'.$v['controller'].'/'.$v['action'];
            if ( $active == $val) {
                $v['active'] = 'active';
            }else{
                $v['active'] = '';
            }
            if ($v['id'] == '50') {
                $v['active'] = 'active';
                $ids = $this->getActiveId($v['id']);
            }
            $access[$key] = $v;
        }

        //添加选中标识
        foreach ($access as $key => $value) {
            if (in_array($value['id'], $ids)) {
                $value['active'] = 'active';
            }else{
                $value['active'] = '0';
            }
            $access[$key] = $value;
        }
        return $access;

    }

    /**
     * [getActivIDs 先获取选中状态]
     * @Author   HUI
     * @DateTime 2020-02-08
     * @version  [version]
     * @param    string     $value [description]
     * @return   [type]            [description]
     */
    public function getActivIDs($access)
    {
        $app = strtolower(app('http')->getName());
        $controller = strtolower(Request::controller());
        $action = strtolower(Request::action());
        $active = $app.'/'.$controller.'/'.$action;

        foreach ($access as $key => $v) {
            $val = $v['app'].'/'.$v['controller'].'/'.$v['action'];
            if ( $active == $val) {
                $v['active'] = 'active';
            }else{
                $v['active'] = '';
            }
            if ($v['id'] == '111') {
                $v['active'] = 'active';
                $ids = $this->getActiveId($v['id']);
            }
            $access[$key] = $v;
        }
        return $access;
    }
    /**
     * [getActiveId 获取当前选中id状态]
     * @Author   HUI
     * @DateTime 2020-02-08
     * @version  [version]
     * @param    [type]     $id        [description]
     * @param    [type]     $parent_id [description]
     * @return   [type]                [description]
     */
    public function getActiveId($id)
    {
        return $this->getTreeParentId($id);
    }

    /**
     * [getTreeParentId 根据id获取父节点id]
     * @Author   HUI
     * @DateTime 2020-02-08
     * @version  [version]
     * @param    [type]     $id [description]
     * @return   [type]         [description]
     */
    public function getTreeParentId($id,&$result = [])
    {

        $result[]=$id;
        if ($id) {
            $res = DB::name('admin_menu')->where('id',$id)->find();
            if (!empty($res['parent_id'])) {
                self::getTreeParentId($res['parent_id'],$result);
            }
        }

        return $result;
    }

    /**
     * [buildMenus 组装目录]
     * @Author   HUI
     * @DateTime 2020-02-07
     * @version  [version]
     * @param    [type]     $formatTree [description]
     * @return   [type]                 [description]
     */
    public function buildMenus($formatTree)
    {
        foreach ($formatTree as $key => $value) {

            if ($value['type'] == 0) {

            }
            print_r($value);exit();





          // <li class="nav-item has-treeview">
          //   <a href="#" class="nav-link">
          //     <i class="nav-icon fas fa-circle"></i>
          //     <p>
          //       Level 1
          //       <i class="right fas fa-angle-left"></i>
          //     </p>
          //   </a>
          //   <ul class="nav nav-treeview">
          //     <li class="nav-item">
          //       <a href="#" class="nav-link">
          //         <i class="far fa-circle nav-icon"></i>
          //         <p>Level 2</p>
          //       </a>
          //     </li>
          //     <li class="nav-item has-treeview">
          //       <a href="#" class="nav-link">
          //         <i class="far fa-circle nav-icon"></i>
          //         <p>
          //           Level 2
          //           <i class="right fas fa-angle-left"></i>
          //         </p>
          //       </a>
          //       <ul class="nav nav-treeview">
          //         <li class="nav-item">
          //           <a href="#" class="nav-link">
          //             <i class="far fa-dot-circle nav-icon"></i>
          //             <p>Level 3</p>
          //           </a>
          //         </li>
          //         <li class="nav-item">
          //           <a href="#" class="nav-link">
          //             <i class="far fa-dot-circle nav-icon"></i>
          //             <p>Level 3</p>
          //           </a>
          //         </li>
          //         <li class="nav-item">
          //           <a href="#" class="nav-link">
          //             <i class="far fa-dot-circle nav-icon"></i>
          //             <p>Level 3</p>
          //           </a>
          //         </li>
          //       </ul>
          //     </li>
          //     <li class="nav-item">
          //       <a href="#" class="nav-link">
          //         <i class="far fa-circle nav-icon"></i>
          //         <p>Level 2</p>
          //       </a>
          //     </li>
          //   </ul>
          // </li>
          // <li class="nav-item">
          //   <a href="#" class="nav-link">
          //     <i class="fas fa-circle nav-icon"></i>
          //     <p>Level 1</p>
          //   </a>
          // </li>

        }
    }

}
