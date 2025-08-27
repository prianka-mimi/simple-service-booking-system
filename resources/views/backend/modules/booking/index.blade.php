@extends('backend.layouts.app')
@php
    use App\Models\Booking;
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
                            <th>User</th>
                            <th>Service</th>
                            <th>Booking Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($bookings->isEmpty())
                            <tr style="background-color: #f2f2f2;">
                                <td colspan="6">
                                    <div class="text-center text-danger fs-6">
                                        {{ __('No Booking Data Found.') }}
                                    </div>
                                </td>
                            </tr>
                        @endif
                        @foreach ($bookings as $booking)
                            <tr>
                                <td class="text-center">
                                    <x-serial :serial="$loop->iteration" :collection="$bookings" />
                                </td>
                                <td>
                                    <strong>{{ $booking->user->name ?? 'N/A' }}</strong>
                                </td>
                                <td>
                                    {{ $booking->service->name ?? 'N/A' }}
                                </td>
                                <td>
                                    {{ $booking->booking_date ? $booking->booking_date->format('M d, Y h:i A') : 'N/A' }}
                                </td>
                                <td>
                                    <button class="btn btn-sm w-80px text-white"
                                        style="background-color: {{ GlobalConstants::STATUS_LIST[$booking->status] }};border:none;">
                                        {{ Booking::STATUS_LIST[$booking->status] ?? '' }}
                                    </button>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('booking.edit', $booking->id) }}" class="mx-1 btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        {{ html()->form('DELETE', route('booking.destroy', $booking->id))->open() }}
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
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
@endsection
