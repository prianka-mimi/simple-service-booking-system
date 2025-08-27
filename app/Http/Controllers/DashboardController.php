<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\Booking;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    final public function index(): View
    {
        $cms_content      = [
            'active_title'    => __('Dashboard'),
        ];

        $totalUsers       = User::getTotalUsers();
        $activeUsers      = User::getActiveUsers();
        $inactiveUsers    = User::getInactiveUsers();

        $totalServices    = Service::getTotalServices();
        $activeServices   = Service::getActiveServices();
        $inactiveServices = Service::getInactiveServices();

        $totalBookings    = Booking::getTotalBookings();
        $activeBookings   = Booking::getActiveBookings();
        $inactiveBookings = Booking::getInactiveBookings();

        $services         = Service::latest()->take(5)->get();

        return view('backend.modules.index', compact(
            'cms_content',
            'totalUsers', 'activeUsers', 'inactiveUsers',
            'totalServices', 'activeServices', 'inactiveServices',
            'totalBookings', 'activeBookings', 'inactiveBookings',
            'services'
        ));
    }
}
