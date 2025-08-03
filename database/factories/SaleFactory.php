<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    public function definition()
    {
        $ticket = Ticket::inRandomOrder()->first() ?? Ticket::factory()->create();
        $quantity = $this->faker->numberBetween(1, 5);
        
        return [
            'ticket_id' => $ticket->id,
            'customer_name' => $this->faker->name,
            'customer_email' => $this->faker->email,
            'quantity' => $quantity,
            'total_price' => $quantity * $ticket->price,
            'status' => 'completed',
        ];
    }
}