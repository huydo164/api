<?php

namespace Modules\User\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Modules\Event\Models\Event;
use Modules\Notification\Models\Notification;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;
    use HasRoles;

    protected $fillable = [
        'email',
        'password',
        'company_name',
        'business_type',
        'business_stage',
        'company_size',
        'founding_date',
        'start_tax_settlement',
        'end_tax_settlement',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function event()
    {
        return $this->hasMay(Event::class);
    }
}
