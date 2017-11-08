<?php

namespace Qla\PermissionManager\app\Http\Controllers;

use Qla\Crud\Controllers\CrudController;
use Qla\DepCRUD\app\Models\Department;
use Qla\PermissionManager\app\Models\User;
use Qla\PermissionManager\app\Models\Role;
use Illuminate\Http\Request;

class UserCRUDController extends CrudController
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var User
     */
    private $department;

    /**
     * @var Role
     */
    private $role;


    /**
     * UserCRUDController constructor.
     * @param User $user
     * @param User $department
     * @param Role $role
     */
    public function __construct(User $user, Department $department, Role $role)
    {
        parent::__construct();
        $this->user = $user;
        $this->department = $department;
        $this->role = $role;
    }

    public function setup()
    {
        $this->crud->route = config('qla.usercrud.route_name_prefix', 'Crud.User');
        $this->crud->permissionName = 'user';
        $this->crud->title = '用户';
        $this->crud->viewName = 'permissionmanager::user';
        $this->crud->setModel('Qla\PermissionManager\app\Models\User');
        $this->crud->setPermissionName('list.user');
    }

    public function getIndex()
    {
        $roles = $this->role->all()->toArray();
        $this->data['roles'] = $roles;
        return parent::getIndex();
    }

    /**
     * @return string
     */
    public function getIndexJson()
    {
        $r = $this->user->with('department', 'roles')->get();

        return json_encode($r);
    }

    /**
     * @return mixed
     */
    public function getAdd()
    {
        $deps = $this->department->getSelectArrayByParentId();
        $roles = $this->role->all()->toArray();

        $this->data['deps'] = $deps;
        $this->data['roles'] = $roles;

        return parent::getAdd();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function postAdd(Request $request)
    {
        $this->data = $_POST;
        $this->data['email'] = $this->data['email'] == '' ? '' : $this->data['email'].'.slyt';
        $this->validator = \Validator::make($this->data, User::rules(), User::messages());
        $this->doAfterCrudData = $this->data['role_ids'] ?? [];

        return parent::storeCrud($request);
    }

    /**
     * @return mixed
     */
    public function getEdit($id)
    {
        $this->data['deps'] = $this->department->getSelectArrayByParentId();
        $model = $this->user->with('roles')->find($id);
        $this->data['model'] = $model;
        $this->data['did'] = $model->dep_id;
        $this->data['roles'] = $this->role->all()->toArray();

        $hasrole = [];
        foreach ($model->roles as $k => $v) {
            array_push($hasrole, $v['id']);
        }

        $this->data['hasrole'] = $hasrole;

        return parent::getEdit($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function postEdit(Request $request)
    {

        $this->data = $_POST;
        $this->data['email'] = $this->data['email'] == '' ? '' : $this->data['email'].'.slyt';
        $this->validator = \Validator::make($this->data, User::rules($this->data['id']), User::messages());
        $this->doAfterCrudData = $this->data['role_ids'] ?? [];

        return parent::updateCrud($request);
    }

    public function del($selectionJson)
    {
        return parent::del($selectionJson);
    }

    public function postGrant($id)
    {
        $data = $_POST;
        $users = json_decode($data['selections']);

        $ids = [];
        foreach ($users as $user) {
            $ids[] = $user->id;
        }

        $this->user->setUsersRole($ids, $id);

        return json_encode(['success' => true, 'message' => '为'.count($ids).'个用户分配权限']);
    }
}