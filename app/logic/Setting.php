<?php
namespace app\logic;

use app\model\Setting as SettingModel;

class Setting extends SettingModel
{
    /**
     * [getSettingList 获取基础列表]
     * @return [type] [description]
     */
    public function getSettingList($category)
    {
        return $this->field('id,title,category,category_name')
            ->where([
                'delete_status' => 0,
                'category' => $category,
            ])->select()->toArray();
    }
}
