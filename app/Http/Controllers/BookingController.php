<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Manager\Traits\CommonResponse;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Http\Resources\BookingListResource;

class BookingController extends Controller
{
    use CommonResponse;

    public static string $route = 'booking';

    /**
     * Display a listing of the resource.
     */
    final public function index(Request $request): View
    {
        $cms_content = [
            'module'       => 'Booking',
            'module_url'   => route(self::$route . '.index'),
            'active_title' => __('List'),
            'button_type'  => 'list',
            'button_title' => __('Create'),
            'button_url'   => route(self::$route . '.create'),
        ];

        $bookings = (new Booking())->getBookingList($request);
        return view('backend.modules.booking.index', compact('cms_content', 'bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create(): View
    {
        $cms_content = [
            'module'       => 'Booking',
            'module_url'   => route(self::$route . '.index'),
            'active_title' => __('Create'),
            'button_type'  => 'list',
            'button_title' => __('List'),
            'button_url'   => route(self::$route . '.index'),
        ];

        $users = User::pluck('name', 'id');
        $services = (new Service())->getServiceAssociated();
        return view('backend.modules.booking.create', compact('cms_content', 'users', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreBookingRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            (new Booking())->storeBooking($request);
            success_alert(__('Booking Created Successfully'));
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('BOOKING_CREATED_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }

        return redirect()->route(self::$route . '.index');
    }

    /**
     * Display the specified resource.
     */
    final public function show(Booking $booking): View
    {
        $cms_content = [
            'module'       => 'Booking',
            'module_url'   => route(self::$route . '.index'),
            'active_title' => __('Details'),
            'button_type'  => 'list',
            'button_title' => __('List'),
            'button_url'   => route(self::$route . '.index'),
        ];

        $booking->load(['user', 'service']);
        return view('backend.modules.booking.show', compact('cms_content', 'booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(Booking $booking): View
    {
        $cms_content = [
            'module'       => 'Booking',
            'module_url'   => route(self::$route . '.index'),
            'active_title' => __('Edit'),
            'button_type'  => 'list',
            'button_title' => __('List'),
            'button_url'   => route(self::$route . '.index'),
        ];

        $users = User::pluck('name', 'id');
        $services = (new Service())->getServiceAssociated();
        return view('backend.modules.booking.edit', compact('cms_content', 'booking', 'users', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateBookingRequest $request, Booking $booking): RedirectResponse
    {
        try {
            DB::beginTransaction();
            (new Booking())->updateBooking($request, $booking);
            success_alert(__('Booking Updated Successfully'));
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('BOOKING_UPDATED_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }

        return redirect()->route(self::$route . '.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Booking $booking): RedirectResponse
    {
        try {
            DB::beginTransaction();
            (new Booking())->deleteBooking($booking);
            success_alert(__('Booking Deleted Successfully'));
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('BOOKING_DELETED_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }

        return redirect()->back();
    }

    final public function storeBooking(StoreBookingRequest $request)
    {
        try {
            (new Booking())->storeBooking($request);
            $this->status_message = 'Booking created successfully.';
        } catch (Throwable $throwable) {
            app_error_log('BOOKING_CREATED_FAILED', $throwable, 'error');
            $this->status_message = $throwable->getMessage();
            $this->status         = false;
            $this->status_code    = $this->status_code_failed;
        }
        return $this->commonApiResponse();
    }

    final public function getBookingList(Request $request)
    {
        try {
            $bookings             = (new Booking())->getBookingListForApi($request);
            $this->data           = BookingListResource::collection($bookings)->response()->getData();
            $this->status_message = 'Booking list fetched successfully.';
        } catch (Throwable $throwable) {
            app_error_log('BOOKING_LIST_FETCH_FAILED', $throwable, 'error');
            $this->status_message = $throwable->getMessage();
            $this->status         = false;
            $this->status_code    = $this->status_code_failed;
        }
        return $this->commonApiResponse();
    }
}
