<?php
namespace app\logic;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Vod\Vod;
use OSS\Core\OssException;
use OSS\OssClient;

class File
{

	public function __construct()
    {
        $this->accessKeyId = 'LTAImHXukA9AUfAc';
        $this->accessKeySecret = 'aHdnjeI2OYhSVhLaeOrisq0GmibgMD';
        $this->regionId = 'cn-shanghai';
        $this->Client = 'Client';
        $this->initVodClient($this->accessKeyId,$this->accessKeySecret);
    }

    //
    public function initVodClient($accessKeyId,$accessKeySecret)
    {
    	return AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)
                ->regionId($this->regionId)
                ->connectTimeout(1)
                ->timeout(3)
                ->name($this->Client);

    }


    //视频上传
    public function uploadVideo($file,$param)
    {	

        switch ($param['channel']) {
            case 'alivod':
                return $this->aliVodUpload($file);
                break;
            default:
                return $this->videoLocalUpload($file,$param);
                break;
        }    

    }

    //视频本地上传
    public function videoLocalUpload($file,$param)
    {
        print_r(makePath('tovideo',2,1));exit;
        if (makePath('tovideo')) {
            return \think\facade\Filesystem::disk('public')->putFile('tovideo', $file);
        }
    }

    //上传至阿里云
    public function aliVodUpload($file)
    {

        $fileName = $file->md5().'.'.$file->extension();
        $auth = $this->CreateUploadVideoAuth('测试',$fileName);
        
        $uploadAuth = json_decode(base64_decode($auth['UploadAuth']), true);
        $UploadAddress = json_decode(base64_decode($auth['UploadAddress']), true);
        try {

            $ossClient = new OssClient(
                $uploadAuth['AccessKeyId'],
                $uploadAuth['AccessKeySecret'],
                $UploadAddress['Endpoint'],
                false,
                $uploadAuth['SecurityToken']
            );

            $ossClient->setTimeout(86400);
            $ossClient->setConnectTimeout(3);
            $ossClient->setUseSSL(false);

            $result = $ossClient->uploadFile($UploadAddress['Bucket'], $UploadAddress['FileName'], $file->getPathName());

            return $auth['VideoId'];
             
        } catch (OssException $e) {
            print $e->getMessage();
        }
    }

    public function CreateUploadVideoAuth($title,$fileName)
    {

		 $auth = Vod::v20170321()->createUploadVideo()->client($this->Client)
	    	->withTitle($title)
	        ->withFileName($fileName)
	        ->format('JSON')
	        ->request();  
	    return $auth->toArray();
    }



    public function getPlayInfo($videoId) {

        // $this->createVideoPlayAuth($videoId);exit();
        $info  = Vod::v20170321()->getPlayInfo()->client($this->Client)
          ->withVideoId($videoId)    // 指定接口参数
          ->withAuthTimeout(3600*24) 
          ->format('JSON')  // 指定返回格式
          ->request();      // 执行请求

        $data = $info->PlayInfoList->PlayInfo;
        // print_r($data);exit();
        if (isset($data[0])) {
            return $data[0]->PlayURL;
        }else{
            return '';
        }

    }

    public function createVideoPlayAuth($videoId)
    {

        $info  = Vod::v20170321()->getVideoPlayAuth()->client($this->Client)
          ->withVideoId($videoId)    // 指定接口参数
          ->withAuthTimeout(3600*24) 
          ->format('JSON')  // 指定返回格式
          ->request();  
        // print_r($info->toArray());exit();
          return $info->toArray();
        
    }




}