<?php

namespace Modules\User\Services;

use App\Services\BaseService;
use Modules\User\Models\User;

class UserService extends BaseService
{
    /**
     * @return User
     */
    public function getModel()
    {
        return User::class;
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
            case 'name':
            case 'email':
                return $query->where($column, 'like', '%' . $data . '%');
                break;
            default:
                return $query;
                break;
        }
    }
}
