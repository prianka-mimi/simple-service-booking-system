@extends('backend.layouts.app')
@section('content')
    {{ html()->modelForm($booking, 'PUT', route('booking.update', $booking->id))->acceptsFiles()->open() }}
    @include('backend.modules.booking.partials._form')
    <x-update-button />
    {{ html()->form()->close() }}
@endsection