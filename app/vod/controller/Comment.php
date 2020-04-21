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
		// $param['table_name']  = 'course';
		$result = $comment->saveComment($param);
		switch ($result) {
			case '0':
				$this->error('评论失败');
				break;
			case '2':
				$this->error('暂不能评论');
				break;
			default:
				$this->success('评论成功');
				break;
		}
		// if ($result) {
		// 	return json(['code'=>1,'message'=>"评论成功"]);
		// }else{
		// 	return json(['code'=>0,'message'=>"评论失败"]);
		// }
	}
}