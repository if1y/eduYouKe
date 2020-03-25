<?php
namespace app\logic;

use app\model\Course as CourseModel;

class Course extends CourseModel
{

    //
    public function getCourseList($where = [], $field = '*')
    {
        return $this->field($field)->where($where)
        ->where(['delete_status'=>0,'show_status'=>1])->select();
    }

}
