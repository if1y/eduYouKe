<?php 
namespace app\api\service;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Vod\Vod;

/**
 * 阿里云视频点播服务（https://help.aliyun.com/product/29932.html?spm=a2c4g.11186623.6.540.76d758fcHhwEp2）
 */
class VodServer
{
    // 阿里云RAM子账号
    private $accessKeyId = "LTAI4Fc1gGbKMgqBrSduFmHi";
    private $accessKeySecret = "POuCJteYNW2YNDHWlZTA8CwQ4EqTEh";

    //媒体上传--初始化客户端
    function initVodClient() {
        $regionId = 'cn-shanghai';
        AlibabaCloud::accessKeyClient($this->accessKeyId, $this->accessKeySecret)
            ->regionId($regionId)
            ->connectTimeout(1)
            ->timeout(3)
            ->name('AliyunVodClientDemo');
    }

    //媒体上传--获取视频上传地址和凭证
    function createUploadVideo($type, $title, $filename) {

        if($type == 0){ //视频
            $templateGroupId = 'c7a323dd3b9a74f0f6159108171daef4';
        }elseif($type == 1){ //音频
            $templateGroupId = '45f1e3e8e3d0b7a0a298a61fe539f696';
        }

        return Vod::v20170321()->createUploadVideo()->client('AliyunVodClientDemo')
            ->withTitle($title)
            ->withTemplateGroupId($templateGroupId)
            ->withFileName($filename)
            ->format('JSON')  //指定返回格式
            ->request();             //执行请求
    }

    //音视频播放--获取视频播放地址
    function getPlayInfo($videoId) {
        return Vod::v20170321()->getPlayInfo()->client('AliyunVodClientDemo')
            ->withVideoId($videoId)
            ->withAuthTimeout(604800)  //播放地址过期时间（秒）
            ->format('JSON')          //指定返回格式
            ->request();                     //执行请求
    }
}