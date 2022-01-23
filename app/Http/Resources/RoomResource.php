<?php

namespace App\Http\Resources;

use App\Models\Room;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Room $room */
        $room = $this;

        return [
            'id'    => $room->id,
            'name'  => $room->name,
        ];
    }
}
