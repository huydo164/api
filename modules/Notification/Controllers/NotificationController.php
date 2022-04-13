<?php

namespace Modules\Notification\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Notification\Models\Notification;
use Modules\Notification\Requests\AuthRequest;
use Modules\Notification\Requests\NotificationRequest;
use Modules\Notification\Resources\NotificationResource;
use Modules\Notification\Services\NotificationService;

/**
 *  @OA\Tag(
 *      name="Notification",
 *      description="Notification Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="notification",
 *      @OA\Property(
 *          property="user_id",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="title",
 *          type="string",
 *          example='Nothing',
 *      ),
 *      @OA\Property(
 *          property="content",
 *          type="string",
 *          example='Nothing',
 *      ),
 *  )
 */
class NotificationController extends Controller
{
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
}
