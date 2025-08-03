<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    public function definition()
    {
        return [
            'event_id' => Event::factory(),
            'type' => $this->faker->randomElement(['General', 'VIP', 'Premium', 'Early Bird']),
            'price' => $this->faker->numberBetween(10, 500),
            'quantity_available' => $this->faker->numberBetween(10, 1000),
        ];
    }
}