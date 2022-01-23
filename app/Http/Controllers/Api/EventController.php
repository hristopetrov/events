<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventCollection;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @parm Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Event::with(['room', 'user'])
                      ->forUser($request->user()->id);

        $events = QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::scope('by_date'),
            ])
            ->get();

        return (new EventCollection($events))
                ->response()
                ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateEventRequest  $request
     * @return JsonResponse
     */
    public function store(CreateEventRequest $request): JsonResponse
    {
        $event = $request->user()->events()->create($request->validated());

        return (new EventResource($event))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  Event $event
     * @return JsonResponse
     */
    public function show(Event $event): JsonResponse
    {
        return (new EventResource($event))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateEventRequest  $request
     * @param  Event $event
     * @return JsonResponse
     */
    public function update(UpdateEventRequest $request, Event $event): JsonResponse
    {
        $event->update($request->validated());

        return (new EventResource($event))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Event $event
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request, Event $event): Response
    {
        throw_unless(
            $request->user()->events->contains($event->id),
            ValidationException::withMessages([
                'code' => 'Unauthorized action.',
            ])
        );

        $event->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }
}
