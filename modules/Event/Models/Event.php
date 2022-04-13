<?php

namespace Modules\Event\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    const EVENT_STATUS_PROCESSING = 1;
    const EVENT_STATUS_DONE = 2;
    const EVENT_STATUS_OUT_OF_DATE = 3;
    const EVENT_STATUS = [
        'processing' => self::EVENT_STATUS_PROCESSING,
        'done' => self::EVENT_STATUS_DONE,
        'outOfDate' => self::EVENT_STATUS_OUT_OF_DATE,
    ];
    /**
     * The attributes that can be select.
     *
     * @var array
     */
    public $selectable = [
        '*',
    ];

    protected $guarded = ['id'];
}
