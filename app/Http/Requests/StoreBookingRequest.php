<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->expectsJson()) {
            $this->merge([
                'user_id' => Auth::id(),
            ]);
        }
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
