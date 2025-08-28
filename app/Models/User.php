<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Manager\Constants\GlobalConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getUserList(Request $request)
    {
        $query = self::query();
        return $query->paginate($request->input('per_page', GlobalConstants::DEFAULT_PAGINATION));
    }

    public static function getTotalUsers()
    {
        return self::count();
    }

    public static function getActiveUsers()
    {
        return self::whereNotNull('email_verified_at')->count();
    }

    public static function getInactiveUsers()
    {
        return self::whereNull('email_verified_at')->count();
    }

    public function storeUser(Request $request, ?array $registration_data = null): Model
    {
        $user = self::query()->create($this->prepare_data($request));
        return $user;
    }

    private function prepare_data(Request $request): array
    {
        $data = [
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'password'  => Hash::make($request->input('password')),
        ];

        return $data;
    }

    final public function get_user_by_column(string $column, string $value, array $relations = []): Model | Null
    {
        $query = self::query()->where($column, $value);
        if ($relations) {
            $query->with($relations);
        }
        return $query->first();
    }

    public function isAdmin(): bool
    {
        return $this->is_admin ?? false;
    }
}
