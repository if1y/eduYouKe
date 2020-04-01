<?php
namespace app\admin\controller;

use app\AdminBaseController;
use think\facade\View;
use app\logic\File as FileLogic;



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
        $file     = request()->file('file');
        $savename = \think\facade\Filesystem::disk('public')->putFile('topic', $file);
        return json(['errno' => 0, 'path'=>$savename ,'data' => [getUrlPath($savename)]]);
    }

    /**
     * [videoUpload 视频上传接口]
     * @return [type] [description]
     */
    public function videoUpload()
    {

        $file     = request()->file('file');
        $vod = new FileLogic();

        $savename = $vod->uploadVideo($file);
        return json(['code' => 1,'path' => $savename]);
        exit;
        //
        $demo = 'AliyunVodClientDemo';
        $regionId = 'cn-shanghai';
        $accessKeyId = 'LTAIc9QzMqt4UneS';
        $accessKeySecret = 'BTxcFrnQw0Q3phgH5lhHkdetEdXANy';
        $client = AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
                ->regionId($regionId)
                ->connectTimeout(1)
                ->timeout(3)
                ->name($demo);



        $res = Vod::v20170321()->CreateUploadVideo()->client($demo)
        ->withTitle('今天测试')
            ->withFileName('a.mp4')
            ->format('JSON')  //指定返回格式
            ->request();     

        print_r($res);exit();

        var_dump($file);exit();
        $savename = \think\facade\Filesystem::disk('public')->putFile('topic', $file);
        return json(['code' => 1,'image'=>'topic/20200216/8faeb459eb13ee09bb23f7abdd9b9cce.jpg','path' => $savename]);
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
