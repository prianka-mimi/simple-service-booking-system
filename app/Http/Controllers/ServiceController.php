<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Service;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Manager\Traits\CommonResponse;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Resources\ServiceListResource;

class ServiceController extends Controller
{
    use CommonResponse;

    public static string $route = 'service';

    /**
     * Display a listing of the resource.
     */
    final public function index(Request $request): View
    {
        $cms_content = [
            'module'       => 'Service',
            'module_url'   => route(self::$route . '.index'),
            'active_title' => __('List'),
            'button_type'  => 'list',
            'button_title' => __('Create'),
            'button_url'   => route(self::$route . '.create'),
        ];

        $services    = (new Service())->getServiceList($request);
        return view('backend.modules.service.index', compact('cms_content', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create(): View
    {
        $cms_content = [
            'module'       => 'Service',
            'module_url'   => route(self::$route . '.index'),
            'active_title' => __('Create'),
            'button_type'  => 'list',
            'button_title' => __('List'),
            'button_url'   => route(self::$route . '.index'),
        ];

        return view('backend.modules.service.create', compact('cms_content'));
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreServiceRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            (new Service())->storeService($request);
            success_alert(__('Service Created Successfully'));
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('SERVICE_CREATED_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }

        return redirect()->route(self::$route . '.index');
    }

    /**
     * Display the specified resource.
     */
    final public function show(Service $service): View
    {
        $cms_content = [
            'module'       => 'Service',
            'module_url'   => route(self::$route . '.index'),
            'active_title' => __('Details'),
            'button_type'  => 'list',
            'button_title' => __('List'),
            'button_url'   => route(self::$route . '.index'),
        ];

        return view('backend.modules.service.show', compact('cms_content', 'service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(Service $service): View
    {
        $cms_content = [
            'module'       => 'Service',
            'module_url'   => route(self::$route . '.index'),
            'active_title' => __('Edit'),
            'button_type'  => 'list',
            'button_title' => __('List'),
            'button_url'   => route(self::$route . '.index'),
        ];

        return view('backend.modules.service.edit', compact('cms_content', 'service'));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        try {
            DB::beginTransaction();
            (new Service())->updateService($request, $service);
            success_alert(__('Service Updated Successfully'));
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('SERVICE_UPDATED_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }

        return redirect()->route(self::$route . '.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Service $service): RedirectResponse
    {
        try {
            DB::beginTransaction();
            (new Service())->deleteService($service);
            success_alert(__('Service Deleted Successfully'));
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('SERVICE_DELETED_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }

        return redirect()->back();
    }

    final public function getServiceList(Request $request){
        try{
            $services             = (new Service())->getServiceListForApi($request);
            $this->data           = ServiceListResource::collection($services)->response()->getData();
            $this->status_message = 'Service list fetched successfully.';
        } catch (Throwable $throwable) {
            app_error_log('SERVICE_LIST_FETCH_FAILED', $throwable, 'error');
            $this->status_message = $throwable->getMessage();
            $this->status         = false;
            $this->status_code    = $this->status_code_failed;
        }
        return $this->commonApiResponse();
    }
}
