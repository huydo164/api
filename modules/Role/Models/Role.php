<?php

namespace Modules\Role\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public const ADMIN = 'admin';

    protected $fillable = [
        'name',
        'guard_name',
    ];
}
