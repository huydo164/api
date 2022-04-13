<?php

namespace Modules\Event\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Event\Models\Event;
use Modules\Event\Requests\EventRequest;
use Modules\Event\Resources\EventResource;
use Modules\Event\Services\EventService;
use PDF;

class EventController extends Controller
{
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->guard('api')->id();
        $data['start_date'] = $request->start_date ?: now()->timestamp;
        $data['order_by'] = 'start_date';
        $data['order_type'] = 'ASC';
        $events = $this->eventService->list($data);

        return EventResource::collection($events);
    }

    public function store(EventRequest $request)
    {
        $data = $request->only('start_date', 'category_id');
        $data['user_id'] = auth()->guard('api')->id();
        $data['status'] = 1;

        $event = $this->eventService->create($data);

        return new EventResource($event);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Event $event
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return new EventResource($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json(null, 204);
    }

    /**
     * Download file pdf.
     *
     * @param Event $event
     */
    public function downloadPdf(Event $event)
    {
        $data = [
            'start_date' => date('Y-m-t', $event['start_date']),
            'problem' => $event['problem'],
            'solution' => $event['solution'],
            'risk' => $event['risk'],
        ];

        $pdf = PDF::loadView('pdf.invoice', compact('data'));

        return $pdf->download('download.pdf');
    }

    /**
     * Update status event to success.
     */
    public function updateStatusEvent(Event $event)
    {
        $event->update(['status' => 2]);

        return new EventResource($event);
    }
}
