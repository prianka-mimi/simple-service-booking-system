@extends('backend.layouts.app')
@section('content')
    {{ html()->form('POST', route('booking.store'))->acceptsFiles()->open() }}
    @include('backend.modules.booking.partials._form')
    <x-create-button />
    {{ html()->form()->close() }}
@endsection