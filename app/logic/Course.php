<?php
namespace app\logic;

use app\model\Course as CourseModel;
use app\util\Tools;

class Course extends CourseModel
{

    //
    public function getCourseList($where = [], $field = '*')
    {
        return $this->field($field)->where($where)
            ->where(['delete_status' => 0, 'show_status' => 1])->select();
    }

    //
    public function baseQuery($where = [], $field = '*', $column = 'create_time', $desc = 'asc', $limit = '0')
    {
        return $this->field($field)->where($where)
            ->where(['delete_status' => 0, 'show_status' => 1])
            ->order($column, $desc)
        // ->order($column, 'asc')
            ->limit($limit)->select();
    }

    //获取最新课程
    public function getNewCourse()
    {
        $field = 'id,category_id,title,cource_image_url,sell_price,cource_tag,sell_status,views,create_time';
        return $this->baseQuery([], $field, 'create_time', '', 4)->each(function ($item)
        {
            $item['cource_image_url'] = getUrlPath($item['cource_image_url']);
            return $item;
        });
    }

    //推荐课程
    public function getRecommendCourse()
    {

        $field = 'id,category_id,title,cource_image_url,sell_price,cource_tag,sell_status,views,create_time';

        return $this->baseQuery([], $field, 'create_time', 'asc', 3)->each(function ($item)
        {
            $item['cource_image_url'] = getUrlPath($item['cource_image_url']);
            return $item;
        });

    }

    //热门课程
    public function getHotCourse()
    {
        $field = 'id,category_id,title,cource_image_url,sell_price,cource_tag,sell_status,views,create_time';

        return $this->baseQuery([], $field, 'create_time', 'desc', 4)->each(function ($item)
        {
            $item['cource_image_url'] = getUrlPath($item['cource_image_url']);
            return $item;
        });

    }

    //猜你喜欢
    public function getConjectureCourse()
    {

        $field = 'id,category_id,title,cource_image_url,sell_price,cource_tag,sell_status,views,create_time';

        return $this->baseQuery([], $field, 'create_time', 'asc', 4)->each(function ($item)
        {
            $item['cource_image_url'] = getUrlPath($item['cource_image_url']);
            return $item;
        });
    }

    //根据课程ID获取面包屑
    public function getBreadcrumb($id)
    {
        $info = $this->getCourseInfo($id);

        $parent = (new CourseCategory())->field('parent_id')->where('id', $info['category_id'])->find();
        $data   = (new CourseCategory())->field('id,title,parent_id')
            ->where(['delete_status' => 0, 'show_status' => 1])->select()->toArray();

        $result = Tools::getBreadcrumb($data, $parent['parent_id']);
        return $result;
    }

    //更新观看日志&&观看次数
    public function updateViewAndLog($param)
    {
        if (isset($param['id']))
        {
            $this->where('id', $param['id'])->inc('views')->update();
        }
        if (getUserInfoData())
        {

            //查询是否已经记录过
            $logs = (new RecordLog())->where([
                'user_id' => getUserInfoData(),
                'key' => $param['id'],
                'category' => 'courseView',
            ])->whereDay('create_time')
                ->find();

            //
            if (empty($logs))
            {
                (new RecordLog())->save([
                    'user_id' => getUserInfoData(),
                    'key' => $param['id'],
                    'category' => 'courseView',
                    'create_time' => time(),
                ]);
            }
        }
    }

}
