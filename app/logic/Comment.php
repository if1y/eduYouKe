<?php
namespace app\logic;

use app\model\Comment as CommentModel;

class Comment extends CommentModel
{
	//添加评论
	public function saveComment($param)
	{

		$result = $this->save([
			'user_id'=>getUserInfoData(),
			'source_id'=> $param['source_id'],
			'content'=> $param['content'],
			'url'=>$param['url'],
			'table_name'=>$param['table_name'],
			'create_time'=>time(),
		]);

        (new RecordLog())->baseSave(
        	'comment',
        	getUserInfoData(),
        	$this->id,
        	$param['table_name']
        );
        
		return $result;
		
	}

	//获取评论列表
	public function getCommentList($table_name,$id)
	{

		$result = $this->alias('c')
            ->field([
            	'co.id',
            	'u.nickname',
            	'u.avatar_url',
            	'u.id',
            	'c.content',
            	'c.create_time',
            ])
            ->join('course co', 'c.source_id = co.id')
            ->join('user u', 'u.id = c.user_id')
            ->order('c.create_time','desc')
            ->where('c.source_id',$id)
            ->paginate(['query' => ['id' => $id], 'list_rows' => 15]);


        return $result;
	}

}