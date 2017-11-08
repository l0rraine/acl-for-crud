<?php

namespace Qla\PermissionManager\app\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends \Kodeine\Acl\Models\Eloquent\Permission
{
    protected $fillable = ['name', 'slug', 'description', 'inherit_id', 'class_id'];

    public function getClassNameAttribute()
    {
        return config('qla.rolecrud.permission_class.'.$this->class_id);
    }
}
