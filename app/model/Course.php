<?php
namespace app\model;

use think\Model;

class Course extends Model
{

    protected $autoWriteTimestamp = true;
    protected $updateTime         = false;


    /**
     * post_content 自动转化
     * @param $value
     * @return string
     */
    public function getContentAttr($value)
    {
        return htmlspecialchars_decode($value);
    }


    /**
     * post_content 自动转化
     * @param $value
     * @return string
     */
    public function getLevelStatusAttr($value)
    {
        $level = ['初级','中级','高级','炼狱'];
        return $level[$value];
    }



     /**
     * post_content 自动转化
     * @param $value
     * @return string
     */
    public function setContentAttr($value)
    {
        return htmlspecialchars($value);
    }


    //获取详情
    public function getCourseInfo($id, $fields = '*')
    {
        if (is_array($id))
        {
            return $this->field($fields)->where($id)->where('delete_status', 0)->find();
        }
        else
        {
            return $this->field($fields)->where('id', $id)->where('delete_status', 0)->find();
        }

    }

}
