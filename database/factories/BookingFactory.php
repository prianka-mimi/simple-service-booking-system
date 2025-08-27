<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'      => User::inRandomOrder()->first()?->id ?? User::factory(),
            'service_id'   => Service::inRandomOrder()->first()?->id ?? Service::factory(),
            'booking_date' => fake()->dateTimeBetween('now', '+1 month'),
            'status'       => fake()->numberBetween(1, 4),
        ];
    }
}
