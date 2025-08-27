<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    final public function index(): View
    {
        $cms_content = [
            'active_title' => __('Dashboard'),
        ];

        return view('backend.modules.index', compact('cms_content'));
    }
}
