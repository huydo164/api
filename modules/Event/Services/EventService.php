<?php

namespace Modules\Event\Services;

use App\Services\BaseService;
use Modules\Event\Models\Event;

class EventService extends BaseService
{
    /**
     * @return Event
     */
    public function getModel()
    {
        return Event::class;
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
            case 'problem':
                return $query->where($column, 'like', '%' . $data . '%');
                break;
            case 'user_id':
            case 'category_id':
                return $query->where($column, $data);
                break;
            case 'start_date':
                $startOfMonth = strtotime(date('Y-m-01 00:00:00', $data));
                $endOfMonth = strtotime(date('Y-m-t 23:59:59', $data));
                return $query->where($column, '>=', $startOfMonth)->where($column, '<=', $endOfMonth);
                break;
            default:
                return $query;
                break;
        }
    }
}
