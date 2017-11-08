<?php

namespace Qla\PermissionManager\app\Http\Controllers;

use Qla\Crud\Controllers\CrudController;
use Qla\PermissionManager\app\Models\Permission;
use Qla\PermissionManager\app\Models\Role;
use Qla\PermissionManager\app\Models\User;
use Illuminate\Http\Request;

class RoleCRUDController extends CrudController
{
    /**
     * @var \App\Models\User
     */
    private $user;

    /**
     * @var \Kodeine\Acl\Models\Eloquent\Role
     */
    private $role;

    /**
     * @var \Kodeine\Acl\Models\Eloquent\Permission
     */
    private $permission;

    /**
     * RoleController constructor.
     *
     * @param \App\Models\User $user
     * @param \Kodeine\Acl\Models\Eloquent\Role $role
     * @param \Kodeine\Acl\Models\Eloquent\Permission $permission
     */
    public function __construct(User $user, Role $role, Permission $permission)
    {
        parent::__construct();
        $this->user = $user;
        $this->role = $role;
        $this->permission = $permission;
    }

    public function setup()
    {
        $this->crud->route = config('qla.rolecrud.route_name_prefix', 'Crud.Role');
        $this->crud->permissionName = 'role';
        $this->crud->title = '角色';
        $this->crud->viewName = 'permissionmanager::acl';
        $this->crud->setModel('Qla\PermissionManager\app\Models\Role');
        $this->crud->setPermissionName('list.role');
    }

    public function getIndex()
    {
        return parent::getIndex();
    }

    public function getIndexJson()
    {
        $data = $this->role->withCount('users')->get();

        return json_encode($data);
    }

    public function getAdd()
    {
        $this->data['permissions'] = $this->permission->orderBy('class_id')->get();

        return parent::getAdd();
    }

    public function postAdd(Request $request)
    {
        $this->data = $_POST;
        $this->validator = \Validator::make($this->data, Role::rules(), Role::messages());
        $this->doAfterCrudData = $this->data['permissions'] ?? [];

        return parent::storeCrud($request);
    }

    public function getEdit($id)
    {


        $model = $this->role->with('permissions')->find($id);
        $ar = $model->permissions->toArray();
        $haspermission = [];
        foreach ($ar as $k => $v) {
            array_push($haspermission, $v['id']);
        }

        $this->data['permissions'] = $this->permission->orderBy('class_id')->get();
        $this->data['model'] = $model;
        $this->data['haspermission'] = $haspermission;

        return parent::getEdit($id);
    }

    public function postEdit(Request $request)
    {
        $this->data = $_POST;
        $this->validator = \Validator::make($this->data, Role::rules(), Role::messages());
        $this->doAfterCrudData = $this->data['permissions'] ?? [];

        return parent::updateCrud($request);
    }

    public function del($selectionJson)
    {
        return parent::del($selectionJson);
    }

    public function getGrant($id)
    {
        $this->crud->description = '分配权限到用户';

        $role = $this->role->with('users')->find($id)->toArray();

        $selections = [];
        foreach ($role['users'] as $k => $v) {
            array_push($selections, $v['id']);
        }


        $this->data['crud'] = $this->crud;
        $this->data['role'] = (object)$role;
        $this->data['selections'] = $selections;

        return parent::getCustomEdit($id);
    }


    public function postGrant()
    {
        $data = $_POST;
        $selections = json_decode($data['selections']);
        $user_ids = [];
        foreach ($selections as $k => $v) {
            array_push($user_ids, $v->id);
        }
        $role_id = $data['role_id'];
        $this->role->find($role_id)->setRoleUsers($user_ids,$role_id);

        return parent::postCustomEdit();
    }
}
