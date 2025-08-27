@extends('backend.layouts.app')
@php
    use App\Models\Service;
    use App\Manager\Constants\GlobalConstants;
@endphp
@section('content')
    <div class="mt-4 row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-stripped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            {{-- <th>Description</th> --}}
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($services->isEmpty())
                            <tr style="background-color: #f2f2f2;">
                                <td colspan="6">
                                    <div class="text-center text-danger fs-6">
                                        {{ __('No Service Data Found.') }}
                                    </div>
                                </td>
                            </tr>
                        @endif
                        @foreach ($services as $service)
                            <tr>
                                <td class="text-center">
                                    <x-serial :serial="$loop->iteration" :collection="$services" />
                                </td>
                                <td>
                                    <strong>{{ $service->name }}</strong>
                                </td>
                                {{-- <td>
                                    {{ Str::limit($service->description, 50) }}
                                </td> --}}
                                <td>
                                    @if($service->price)
                                        ${{ number_format($service->price, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm w-80px text-white"
                                        style="background-color: {{ GlobalConstants::STATUS_LIST_COLOR[$service->status] }};border:none;">
                                        {{ Service::STATUS_LIST[$service->status] ?? '' }}
                                    </button>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('service.show', $service->id) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('service.edit', $service->id) }}" class="mx-1 btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        {{ html()->form('DELETE', route('service.destroy', $service->id))->open() }}
                                        <button type="button" class="btn btn-sm btn-danger delete-btn">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        {{ html()->form()->close() }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $services->links() }}
            </div>
        </div>
    </div>
@endsection
