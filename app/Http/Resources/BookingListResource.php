<?php

namespace App\Http\Resources;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'service'      => $this->service ?? [],
            'booking_date' => $this->booking_date->format('D-M-Y H:i:s'),
            'status'       => $this->status ?? [],
            'status_list'  => Booking::STATUS_LIST ?? [],
        ];
    }
}
