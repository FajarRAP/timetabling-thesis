<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LectureSlotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'day' => $this->day,
            'time_slot' => $this->timeSlot,
            'room_class' => $this->roomClass,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
