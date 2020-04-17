<?php
namespace app\vod\controller;

use app\UserBaseController;
use think\facade\View;
use app\logic\Comment as CommentLogic;


class Comment extends UserBaseController
{
	//添加评论
	public function addComment()
	{	
		//
        $param = $this->request->param();
		$comment = new CommentLogic();
		$param['table_name']  = 'course';
		$result = $comment->saveComment($param);
		if ($result) {
			return json(['code'=>1,'message'=>"评论成功"]);
		}else{
			return json(['code'=>0,'message'=>"评论失败"]);
		}
	}
}