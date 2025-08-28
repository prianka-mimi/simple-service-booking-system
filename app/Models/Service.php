<?php

namespace App\Models;

use App\Manager\Constants\GlobalConstants;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE      => 'Active',
        self::STATUS_INACTIVE    => 'Inactive',
    ];

    public function getServiceList(Request $request, array|null $columns = null)
    {
        $query = self::query()->orderByDesc('id');
        return $query->paginate($request->input('per_page', GlobalConstants::DEFAULT_PAGINATION));
    }

    final public function storeService(Request $request): Model
    {
        return self::query()->create($this->prepareData($request));
    }

    public function updateService(Request $request, Service $service)
    {
        return $service->update($this->prepareData($request));
    }

    private function prepareData(Request $request): array
    {
        return [
            'name'        => $request->input('name'),
            'description' => $request->input('description'),
            'price'       => $request->input('price'),
            'status'      => $request->input('status') ?? self::STATUS_ACTIVE,
        ];
    }

    final public function deleteService(Service $service): void
    {
        $service->delete();
    }

    final public function getServiceAssociated()
    {
        return self::query()
            ->where('status', self::STATUS_ACTIVE)
            ->pluck('name', 'id');
    }

    public static function getTotalServices()
    {
        return self::count();
    }

    public static function getActiveServices()
    {
        return self::where('status', self::STATUS_ACTIVE)->count();
    }

    public static function getInactiveServices()
    {
        return self::where('status', self::STATUS_INACTIVE)->count();
    }

    public function getServiceListForApi(Request $request): mixed
    {
        return self::query()
            ->where('status', self::STATUS_ACTIVE)
            ->select('id','name', 'description', 'price')
            ->paginate($request->input('per_page', GlobalConstants::DEFAULT_PAGINATION));
    }
}
