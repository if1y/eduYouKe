<?php
namespace app\logic;

use app\model\Chapter as ChapterModel;

class Chapter extends ChapterModel
{


	public function baseQuery($where = [], $field = '*', $column = 'create_time', $desc = 'asc', $limit = '0')
    {
        return $this->field($field)->where($where)
            ->where(['delete_status' => 0, 'show_status' => 1])
            ->order($column, $desc)
            ->limit($limit)->select();
    }

    //获取章节
	public function getChapter($id)
	{

		$result = $this->baseQuery(['course_id'=>$id],'id,course_id,title,description');

		foreach ($result as $key => $value) {

			$value['video'] = (new CourseVideo())
			->baseQuery(['chapter_id'=>$value['id']],'id,chapter_id,course_id,title');

			$result[$key] = $value;
		}
		// print_r($result->toArray());exit();
		return $result;
	}

	//获取推荐课程
	public function getRecommendRoundCourse($categoryId)
	{


		$result = $this->alias('ch')
            ->field([
            	'ch.title as chapter_title',
            	'ch.id as chapter_id',
            	'co.title as course_title',
            	'co.id as course_id',
            	'co.description',
            	'co.sell_price',
            	'co.cource_image_url',
            ])
            ->join('course co', 'ch.course_id = co.id')
            ->join('course_category cat', 'cat.id = co.category_id')
            ->orderRaw('rand()')
            ->limit(6)
			->group('co.id')
            ->select();

        // print_r($result->toArray());exit();
        return $result;

	}

}
