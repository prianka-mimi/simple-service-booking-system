@extends('backend.layouts.app')
@section('content')
    {{ html()->modelForm($service, 'PUT', route('service.update', $service->id))->acceptsFiles()->open() }}
    @include('backend.modules.service.partials._form')
    <x-update-button />
    {{ html()->form()->close() }}
@endsection
