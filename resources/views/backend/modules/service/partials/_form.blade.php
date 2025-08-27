@php
use App\Models\Service;
@endphp

<div class="mt-4 row">
    <div class="col-lg-6">
        <div class="mb-4 custom-input-group">
            {{ html()->label(__('Name'), 'name')->class('form-label') }}
            <x-required />
            {{ html()->text('name')->id('name')->class('form-control ' . ($errors->has('name') ? ' is-invalid' : null))->placeholder(__('Enter service name')) }}
            @error('name')
                <x-validation-error :message="$message" />
            @enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-4 custom-input-group">
            {{ html()->label(__('Price'), 'price')->class('form-label') }}
            <x-required />
            {{ html()->number('price')->id('price')->class('form-control ' . ($errors->has('price') ? ' is-invalid' : null))->placeholder(__('Enter price')) }}
            @error('price')
                <x-validation-error :message="$message" />
            @enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-4 custom-input-group">
            {{ html()->label(__('Status'), 'status')->class('form-label') }}
            {{ html()->select('status', Service::STATUS_LIST, isset($service) ? $service->status : Service::STATUS_ACTIVE)->id('status')->class('form-select ' . ($errors->has('status') ? ' is-invalid' : null))->placeholder(__('Select status')) }}
            @error('status')
                <x-validation-error :message="$message" />
            @enderror
        </div>
    </div>
    <div class="col-lg-12">
        <div class="mb-3 form-group">
            {{ html()->label(__('Description'))->for('description') }}
            {{ html()->textarea('description')->id('description')->class('form-control ' . ($errors->has('description') ? ' is-invalid' : null))->placeholder(__('Enter service description'))->rows(4) }}
            @error('description')
                <x-validation-error :message="$message" />
            @enderror
        </div>
    </div>
</div>
