<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'      => 'required|exists:users,id',
            'service_id'   => 'required|exists:services,id',
            'booking_date' => 'required|date|after:now',
            'status'       => 'nullable|in:' . implode(',', array_keys(Booking::STATUS_LIST)),
        ];
    }
}
