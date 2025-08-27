@php
    use App\Models\Booking;
@endphp

{{ html()->form('get', route('booking.index'))->id('search_form')->open() }}
{{ html()->hidden('per_page')->value($search['per_page'] ?? 20) }}

<div class="mt-4 mb-4 row justify-content-center align-items-end">
    <div class="mb-4 col-md-3">
        {{ html()->label(__('User'), 'user_id') }}
        {{ html()->select('user_id', $users ?? [], $search['user_id'] ?? null)->class('form-control form-control-sm')->placeholder(__('Select User')) }}
    </div>

    <div class="mb-4 col-md-3">
        {{ html()->label(__('Service'), 'service_id') }}
        {{ html()->select('service_id', $services ?? [], $search['service_id'] ?? null)->class('form-control form-control-sm')->placeholder(__('Select Service')) }}
    </div>

    <div class="mb-4 col-md-3">
        {{ html()->label(__('Status'), 'status') }}
        {{ html()->select('status', Booking::STATUS_LIST, $search['status'] ?? null)->class('form-control form-control-sm')->placeholder(__('Select Status')) }}
    </div>

    <div class="mb-4 col-md-3">
        <label for="order_by_column">{{ __('Order By') }}</label>
        {{ html()->select('order_by_column', $columns ?? [], $search['order_by_column'] ?? null)->class('form-select form-select-sm')->placeholder(trans('Sort Order By')) }}
    </div>
    <div class="mb-4 col-md-3">
        <label for="order_by">{{ __('ASC/DESC') }}</label>
        {{ html()->select('order_by', ['asc' => trans('ASC'), 'desc' => trans('DESC')], $search['order_by'] ?? null)->placeholder(trans('Select ASC/DESC'))->class('form-select form-select-sm') }}
    </div>
    <x-search-submit-reset-button />
</div>
{{ html()->form()->close() }}