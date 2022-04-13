<?php

namespace Modules\Notification\Services;

use App\Services\BaseService;
use Modules\Notification\Models\Notification;

class NotificationService extends BaseService
{
    /**
     * @return Notification
     */
    public function getModel()
    {
        return Notification::class;
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
            case 'title':
            case 'content':
                return $query->where($column, 'like', '%' . $data . '%');
                break;
            case 'user_id':
                return $query->where($column, $data);
                break;
            default:
                return $query;
                break;
        }
    }
}
