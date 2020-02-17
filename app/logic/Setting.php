<?php
namespace app\logic;

use app\model\Setting as SettingModel;

class Setting extends SettingModel
{
    /**
     * [getSettingList 获取基础列表]
     * @return [type] [description]
     */
    public function getSettingCategoryList($category)
    {
        return $this->where([
                'delete_status' => 0,
                'show_status' => 1,
                'category' => $category,
            ])->select()->toArray();
    }

    /**
     * [getSettingList 获取基础列表]
     * @return [type] [description]
     */
    public function getSettingList()
    {

        // return 
        $result = $this->field('id,title,category,category_name')
            ->where([
                'delete_status' => 0,
                'show_status' => 1,
                'category' => 'base',
            ])->select()->each(function ($item) {
                $item['child']   = $this->getSettingCategoryList($item['category_name']);
            });

            return $result;

        // print_r($result);exit();
    }


    /**
     * [saveSettingPost description]
     * @param  [type] $param [description]
     * @return [type]        [description]
     */
    public function saveSettingPost($param)
    {
        foreach ($param as $key => $value) {
            $this->update(['content'=>$value],['category'=>$param['type'],'category_name'=>$key]);
        }
    }


}
