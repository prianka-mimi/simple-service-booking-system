@extends('backend.layouts.app')
@php
    use App\Models\Booking;
    use App\Manager\Constants\GlobalConstants;
@endphp
@section('content')
    <div class="mt-4 row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Booking Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-md table-bordered table-striped table-hover">
                        <tbody>
                            <tr>
                                <th width="200">User</th>
                                <td>{{ $booking->user->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Service</th>
                                <td>{{ $booking->service->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Booking Date</th>
                                <td>{{ $booking->booking_date ? $booking->booking_date->format('M d, Y h:i A') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge" style="background-color: {{ GlobalConstants::STATUS_LIST_COLOR[$booking->status] }};">
                                        {{ Booking::STATUS_LIST[$booking->status] ?? '' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $booking->created_at->toDayDateTimeString() }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $booking->created_at != $booking->updated_at ? $booking->updated_at->toDayDateTimeString() : 'Not updated yet' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="d-flex justify-content-start align-items-center">
                <a href="{{ route('booking.index') }}">
                   <x-show-back-button />
                </a>
            </div>
        </div>
    </div>
@endsection