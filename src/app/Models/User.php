<?php

namespace Qla\PermissionManager\app\Models;

use Qla\Base\app\Models\BaseClassifiedModel;
use Qla\Crud\ModelTraits\BaseModelTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kodeine\Acl\Traits\HasRole;

class User extends BaseClassifiedModel
{
    use Notifiable, HasRole, BaseModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'dep_id',
        'phone_num',
        'ip',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = ['department'];

    public static function rules($id = 0, $merge = [])
    {
        return array_merge([
            'email' => 'required|unique:users,email,'.($id ? $id.",id" : ''),
            'dep_id' => 'required',
            'ip' => 'ip',
            'phone_num' => 'phone'
        ], $merge);
    }

    public static function messages($id = 0, $merge = [])
    {
        return array_merge([
            'email.required' => '必须填写邮箱地址！',
            'dep_id.required' => '必须填写单位！',
            'email.unique' => '邮箱已被注册！',
        ], $merge);
    }

    public function doAfterCU($data = [])
    {
        $this->setRoles($data);
    }

    public function setEmailAttribute($value)
    {
        $value = str_replace('.slyt', '', $value);
        $this->attributes['email'] = $value.'.slyt';
        $this->attributes['password'] = bcrypt(random_int(100000, 1000000));
    }

    public function getEmailAttribute($value)
    {
        return str_replace('.slyt', '', $value);
    }

    public function findByEmail($email)
    {
        return $this->where('email', $email);
    }

    public function department()
    {
        return $this->hasOne('App\Models\Department', 'id', 'dep_id');
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        \DB::table('role_user')->where('user_id', $this->id)->delete();
        foreach ($roles as $k => $v) {
            \DB::table('role_user')->insert(['user_id' => $this->id, 'role_id' => $v]);
        }
    }

    /**
     * 批量设置角色到多个用户
     * @param array $user_ids
     * @param int $role_id
     */
    public function setUsersRole($user_ids, $role_id)
    {
        foreach ($user_ids as $user_id) {
            if (\DB::table('role_user')->where('user_id', $user_id)->where('role_id', $role_id)->count() == 0) {
                \DB::table('role_user')->insert(['user_id' => $user_id, 'role_id' => $role_id]);
            }
        }
    }
}