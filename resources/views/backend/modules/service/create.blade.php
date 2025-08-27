@extends('backend.layouts.app')
@section('content')
    {{ html()->form('POST', route('service.store'))->acceptsFiles()->open() }}
    @include('backend.modules.service.partials._form')
    <x-create-button />
    {{ html()->form()->close() }}
@endsection
