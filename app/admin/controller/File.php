<?php
namespace app\admin\controller;

use app\AdminBaseController;
use think\facade\View;
use app\logic\File as FileLogic;
use app\logic\Image;



class File extends AdminBaseController
{
    //登录
    public function filelist()
    {
        return View::fetch('');
    }

    //登录
    public function file()
    {
        return View::fetch('');
    }

    /**
     * [upload 图片上传接口]
     * @return [type] [description]
     */
    public function imageUpload()
    {

        $file = $this->request->file('file');
        $param = $this->request->param();
        $image = new Image();
        $savename = $image->uploadImage($file,$param);
        return json([
            'errno' => 0,
            'path'=>$savename ,
            'data' => $image->editorImage($savename)
        ]);
    }

    /**
     * [videoUpload 视频上传接口]
     * @return [type] [description]
     */
    public function uploadVideo()
    {

        $file = $this->request->file('file');
        $param = $this->request->param();
        $vod = new FileLogic();
        $savename = $vod->uploadVideo($file,$param);
        return json(['code' => 1,'path' => $savename]);
    }

    /**
     * [uploadCloud 更新到云上]
     * @return [type] [description]
     */
    public function uploadCloud()
    {
        return json(['code'=>1,'message'=> '上传成功']);
    }



}
