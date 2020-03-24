<?php
namespace app\logic;

use app\model\AdminUser as AdminUserModel;

class AdminUser extends AdminUserModel
{

    /**
     * [getUserList ]
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function getAdminUserList()
    {

        $result = $this->alias('a')
            ->field([
                'a.*',
                'r.role_name',
            ])
            ->leftJoin('admin_role r', 'a.role_id = r.id')
            ->where([
                'a.delete_status' => 0,
            ])
            ->paginate(12);
        return $result;
    }


}
