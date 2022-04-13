<?php

namespace Modules\User\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Notification\Resources\NotificationResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'menus' => $this->menus,
            'company_name' => $this->company_name,
            'start_tax_settlement' => $this->start_tax_settlement,
            'end_tax_settlement' => $this->end_tax_settlement,
            'business_type' => $this->business_type,
            'company_size' => $this->company_size,
            'business_stage' => $this->business_stage,
            'founding_date' => $this->founding_date,
            'notifications' => NotificationResource::collection($this->notifications),
        ];
    }
}
