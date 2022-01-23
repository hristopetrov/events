<?php

namespace App\Http\Resources;

use App\Models\Event;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Event $event */
        $event = $this;

        return [
            'id'       => $event->id,
            'name'     => $event->name,
            'start_at' => $event->start_at,
            'end_at'   => $event->end_at,
            'room'     => $this->whenLoaded('room', function () use ($event) {
                return new RoomResource($event->room);
            }),
            'user'     => $this->whenLoaded('user', function () use ($event) {
                return new UserResource($event->user);
            })
        ];
    }
}
