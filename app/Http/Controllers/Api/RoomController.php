<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUpdateRoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUpdateRoomRequest  $request
     * @return JsonResponse
     */
    public function store(CreateUpdateRoomRequest $request): JsonResponse
    {
        $room = Room::create($request->validated());

        return (new RoomResource($room))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  Room $room
     * @return JsonResponse
     */
    public function show(Room $room): JsonResponse
    {
        return (new RoomResource($room))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  CreateUpdateRoomRequest  $request
     * @param  Room $room
     * @return JsonResponse
     */
    public function update(CreateUpdateRoomRequest $request, Room $room): JsonResponse
    {
        $room->update($request->validated());

        return (new RoomResource($room))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Room $room
     * @return Response
     */
    public function destroy(Room $room): Response
    {
        $room->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }
}
