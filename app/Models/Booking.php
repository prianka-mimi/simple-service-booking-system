<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Manager\Constants\GlobalConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'booking_date' => 'datetime',
    ];

    public const STATUS_PENDING   = 1;
    public const STATUS_CONFIRMED = 2;
    public const STATUS_CANCELLED = 3;
    public const STATUS_COMPLETED = 4;

    public const STATUS_LIST = [
        self::STATUS_PENDING     => 'Pending',
        self::STATUS_CONFIRMED   => 'Confirmed',
        self::STATUS_CANCELLED   => 'Cancelled',
        self::STATUS_COMPLETED   => 'Completed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getBookingList(Request $request, array|null $columns = null)
    {
        $query = self::query()->with(['user', 'service'])->orderByDesc('id');

        return $query->paginate($request->input('per_page', GlobalConstants::DEFAULT_PAGINATION));
    }

    final public function storeBooking(Request $request): Model
    {
        return self::query()->create($this->prepareData($request));
    }

    public function updateBooking(Request $request, Booking $booking)
    {
        return $booking->update($this->prepareData($request));
    }

    private function prepareData(Request $request): array
    {
        return [
            'user_id'      => $request->input('user_id'),
            'service_id'   => $request->input('service_id'),
            'booking_date' => $request->input('booking_date'),
            'status'       => $request->input('status') ?? self::STATUS_PENDING,
        ];
    }

    final public function deleteBooking(Booking $booking): void
    {
        $booking->delete();
    }

    public static function getTotalBookings()
    {
        return self::count();
    }

    public static function getActiveBookings()
    {
        return self::whereIn('status', [self::STATUS_PENDING, self::STATUS_CONFIRMED])->count();
    }

    public static function getInactiveBookings()
    {
        return self::whereIn('status', [self::STATUS_CANCELLED, self::STATUS_COMPLETED])->count();
    }

    public function getBookingListForApi(Request $request): mixed
    {
        return self::query()
            ->with(['user:id,name', 'service:id,name'])
            ->where('user_id', Auth::id())
            ->select('id', 'user_id', 'service_id', 'booking_date', 'status')
            ->paginate($request->input('per_page', GlobalConstants::DEFAULT_PAGINATION));
    }
}
