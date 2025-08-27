@extends('backend.layouts.app')
@php
    use App\Models\Service;
    use App\Manager\Constants\GlobalConstants;
@endphp
@section('content')
    <div class="mt-4 row">
        <div class="col-md-12">
            <div class="card-body">
                <table class="table table-md table-bordered table-striped table-hover">
                    <tbody>
                        <tr>
                            <th width="200">Name</th>
                            <td>{{ $service->name }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $service->description ?? 'No description available' }}</td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td>
                                @if($service->price)
                                    ${{ number_format($service->price, 2) }}
                                @else
                                    Not specified
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge"
                                    style="background-color: {{ GlobalConstants::STATUS_LIST_COLOR[$service->status] }};">
                                    {{ Service::STATUS_LIST[$service->status] ?? '' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $service->created_at->toDayDateTimeString() }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $service->created_at != $service->updated_at ? $service->updated_at->toDayDateTimeString() : 'Not updated yet' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="d-flex justify-content-start align-items-center">
                <a href="{{ route('service.index') }}">
                    <x-show-back-button />
                </a>
            </div>
        </div>
    </div>
@endsection
