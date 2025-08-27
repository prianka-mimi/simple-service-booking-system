@php
    use App\Models\Booking;
@endphp

<div class="mt-4 row">
    <div class="col-lg-6">
        <div class="mb-4 custom-input-group">
            {{ html()->label(__('User'), 'user_id')->class('form-label') }}
            <x-required />
            {{ html()->select('user_id', $users ?? [], isset($booking) ? $booking->user_id : null)->id('user_id')->class('form-select ' . ($errors->has('user_id') ? ' is-invalid' : null))->placeholder(__('Select user')) }}
            @error('user_id')
                <x-validation-error :message="$message" />
            @enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-4 custom-input-group">
            {{ html()->label(__('Service'), 'service_id')->class('form-label') }}
            <x-required />
            {{ html()->select('service_id', $services ?? [], isset($booking) ? $booking->service_id : null)->id('service_id')->class('form-select ' . ($errors->has('service_id') ? ' is-invalid' : null))->placeholder(__('Select service')) }}
            @error('service_id')
                <x-validation-error :message="$message" />
            @enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-4 custom-input-group">
            {{ html()->label(__('Booking Date'), 'booking_date')->class('form-label') }}
            <x-required />
            {{ html()->datetime('booking_date')->id('booking_date')->class('form-control ' . ($errors->has('booking_date') ? ' is-invalid' : null)) }}
            @error('booking_date')
                <x-validation-error :message="$message" />
            @enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-4 custom-input-group">
            {{ html()->label(__('Status'), 'status')->class('form-label') }}
            {{ html()->select('status', Booking::STATUS_LIST, isset($booking) ? $booking->status : Booking::STATUS_PENDING)->id('status')->class('form-select ' . ($errors->has('status') ? ' is-invalid' : null))->placeholder(__('Select status')) }}
            @error('status')
                <x-validation-error :message="$message" />
            @enderror
        </div>
    </div>
</div>