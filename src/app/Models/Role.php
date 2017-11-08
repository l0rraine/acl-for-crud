<?php

namespace Qla\PermissionManager\app\Models;

use Qla\Crud\ModelTraits\BaseModelTrait;

class Role extends \Kodeine\Acl\Models\Eloquent\Role
{
    use BaseModelTrait;

    public static function rules($id = 0, $merge = [])
    {
        return array_merge([
            'name' => 'required',
            'slug' => 'required',
        ],$merge);
    }

    public static function messages($id = 0, $merge = [])
    {
        return array_merge([
            'name.required' => '必须填写名称',
            'slug.required' => '必须填写缩写',
        ],$merge);
    }

    public function doAfterCU($data = [])
    {
        $this->setPermission($data);
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = htmlspecialchars($value);
    }

    public function getSlugAttribute($value)
    {
        return htmlspecialchars_decode($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = htmlspecialchars($value);
    }

    public function getDescriptionAttribute($value)
    {
        return htmlspecialchars_decode($value);
    }

    /**
     * @param array $permissions
     */
    public function setPermission($permissions)
    {
        \DB::table('permission_role')->where('role_id',$this->id)->delete();
        foreach ($permissions as $k=>$v){
            \DB::table('permission_role')->insert(['role_id'=>$this->id,'permission_id'=>$v]);
        }

    }

    public function setRoleUsers($user_ids, $role_id)
    {
        \DB::table('role_user')->where('role_id',$role_id)->delete();
        foreach ($user_ids as $user_id) {
            \DB::table('role_user')->insert(['user_id' => $user_id, 'role_id' => $role_id]);
        }
    }

}
