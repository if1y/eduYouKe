<?php
namespace app\user\controller;

use app\logic\Image;
use app\logic\User as UserLogic;
use app\WebBaseController;
use app\util\Tools;
use app\logic\Order;
use think\facade\View;

class User extends WebBaseController
{

    protected $middleware = ['auth'];
    
    protected function initialize()
    {
        parent::initialize();
        $this->userInfo = $this->getUserCentor();
        View::assign('userinfo', $this->userInfo);

    }

    //用户中心
    public function centor()
    {
        $param = $this->request->param();

        $user    = new UserLogic();
        $history = $user->getUserHistory($param);

        return view('', [
            'history' => $history,
            'page' => $history->render(),
        ]);
    }

    //用户订单
    public function order()
    {
        if (!$this->userInfo['myself'])
        {
            return redirect((string) url('user/centor', ['user_id' => $this->userId]));
        }

        $order = new Order();
        $list = $order->getUserOrderList();
        return view('', [
            'list' => $list,
            'page' => $list->render(),
        ]);

    }

    //用户学习历史
    public function history()
    {
        if (!$this->userInfo['myself'])
        {
            return redirect((string) url('user/centor', ['user_id' => $this->userId]));
        }
        return view('');
    }

    //用户消息列表
    public function message()
    {

        if (!$this->userInfo['myself'])
        {
            return redirect((string) url('user/centor', ['user_id' => $this->userId]));
        }
        return view('');
    }

    public function setting()
    {
        $param = $this->request->param();
        $user  = new UserLogic();
        if ($this->request->isPost())
        {
            unset($param['user_id']);
            $param['password'] = !empty($param['password']) ? Tools::userMd5($param['password']) : 0;
            if (!$param['password'])
            {
                unset($param['password']);
            }

            $user->where('id', getUserInfoData())->save($param);

            //更新session
            if ($param['nickname'])
            {
                $user->updateSession(0, 'nickname', $param['nickname']);
            }

            return redirect((string) url('user/setting', ['user_id' => getUserInfoData()]));
        }
        else
        {
            if (!$this->userInfo['myself'])
            {
                return redirect((string) url('user/centor', ['user_id' => $this->userId]));
            }

            $this->userInfo['mobile'] = substr($this->userInfo['mobile'], 0, 3) . '****' . substr($this->userInfo['mobile'], 7);

            return view('', [
                'userinfo' => $this->userInfo,
            ]);
        }
    }

    //头像上传
    public function avatar()
    {
        $file  = $this->request->file('file');
        $param = $this->request->param();

        $image    = new Image();
        $savename = $image->uploadImage($file, $param);
        $user     = new UserLogic();
        $userId   = getUserInfoData();
        //更新Session头像
        $user->updateSession(0, 'avatar_url', $savename);
        $user->where('id', $userId)->save(['avatar_url' => $savename]);
        return json(['code' => 1, 'message' => '上传成功']);
    }

}
