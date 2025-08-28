<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Manager\Traits\CommonResponse;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Resources\ServiceListResource;

class ServiceApiController extends Controller
{

    use CommonResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        if (!auth()->user()->isAdmin()) {
            $this->status = false;
            $this->status_message = 'Access denied. Admin permission required.';
            $this->status_code = 403;
            return $this->commonApiResponse();
        }

        try {
            (new Service())->storeService($request);
            $this->status_message = 'Service created successfully.';
        } catch (Throwable $throwable) {
            app_error_log('SERVICE_CREATED_FAILED', $throwable, 'error');
            $this->status_message = $throwable->getMessage();
            $this->status         = false;
            $this->status_code    = $this->status_code_failed;
        }
        return $this->commonApiResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->isAdmin()) {
            $this->status = false;
            $this->status_message = 'Access denied. Admin permission required.';
            $this->status_code = 403;
            return $this->commonApiResponse();
        }

        try {
            $service = Service::find($id);
            if (!$service) {
                $this->status = false;
                $this->status_message = 'Service not found.';
                $this->status_code = 404;
                return $this->commonApiResponse();
            }

            (new Service())->updateService($request, $service);
            $this->status_message = 'Service updated successfully.';
        } catch (Throwable $throwable) {
            app_error_log('SERVICE_UPDATED_FAILED', $throwable, 'error');
            $this->status_message = $throwable->getMessage();
            $this->status         = false;
            $this->status_code    = $this->status_code_failed;
        }
        return $this->commonApiResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!auth()->user()->isAdmin()) {
            $this->status = false;
            $this->status_message = 'Access denied. Admin permission required.';
            $this->status_code = 403;
            return $this->commonApiResponse();
        }

        try {
            $service = Service::find($id);
            if (!$service) {
                $this->status = false;
                $this->status_message = 'Service not found.';
                $this->status_code = 404;
                return $this->commonApiResponse();
            }

            (new Service())->deleteService($service);
            $this->status_message = 'Service deleted successfully.';
        } catch (Throwable $throwable) {
            app_error_log('SERVICE_DELETED_FAILED', $throwable, 'error');
            $this->status_message = $throwable->getMessage();
            $this->status         = false;
            $this->status_code    = $this->status_code_failed;
        }
        return $this->commonApiResponse();
    }
}
