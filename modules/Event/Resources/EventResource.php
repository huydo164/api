<?php

namespace Modules\Event\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Event\Models\Event;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'start_date' => $this->start_date,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'problem' => $this->problem,
            'solution' => $this->solution,
            'risk' => $this->risk,
            'status' => $this->status,
            'status_cal' => ($this->status !== Event::EVENT_STATUS['done'] && $this->start_date < today()->timestamp) ? Event::EVENT_STATUS['outOfDate'] : $this->status,// get status out of date
        ];
    }
}
