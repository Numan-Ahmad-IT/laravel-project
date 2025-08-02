<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    public function definition()
    {
        return [
            'event_id' => \App\Models\Event::factory(),
            'type' => $this->faker->randomElement(['General Admission', 'VIP', 'Premium', 'Early Bird']),
            'price' => $this->faker->numberBetween(10, 500),
            'quantity_available' => $this->faker->numberBetween(50, 1000),
        ];
    }
}