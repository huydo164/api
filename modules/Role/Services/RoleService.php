<?php

namespace Modules\Role\Services;

use App\Services\BaseService;
use DB;
use Modules\Role\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleService extends BaseService
{
    /**
     * @return Role
     */
    public function getModel()
    {
        return Role::class;
    }

    /**
     * @param mixed $query
     * @param mixed $column
     * @param mixed $data
     *
     * @return Query
     */
    public function search($query, $column, $data)
    {
        switch ($column) {
            case 'not':
                return $query->where('name', '!=', $data);
                break;
            case 'name':
                return $query->where($column, 'like', '%' . $data . '%');
                break;
            default:
                return $query;
                break;
        }
    }

    /**
     * @return void
     */
    public function clean(Role $role)
    {
        DB::table('model_has_roles')->where('role_id', $role->id)->delete();
        $role->syncPermissions();
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }

    /**
     * Get permission list.
     *
     * @return Permission
     */
    public function getPermissions()
    {
        return Permission::all();
    }
}
