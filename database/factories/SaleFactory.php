<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    public function definition()
    {
        return [
            'ticket_id' => \App\Models\Ticket::factory(),
            'customer_name' => $this->faker->name,
            'customer_email' => $this->faker->email,
            'quantity' => $this->faker->numberBetween(1, 5),
            'total_amount' => function (array $attributes) {
                $ticket = \App\Models\Ticket::find($attributes['ticket_id']);
                return $ticket->price * $attributes['quantity'];
            },
            'purchase_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}