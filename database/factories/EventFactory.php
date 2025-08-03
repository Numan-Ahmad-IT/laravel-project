<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('now', '+3 months');
        
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(3),
            'start_date' => $startDate,
            'end_date' => $this->faker->dateTimeBetween($startDate, '+4 months'),
            'location' => $this->faker->address,
            'image' => 'event-images/' . $this->faker->randomElement([
                'concert.jpg',
                'conference.jpg',
                'sports.jpg',
                'exhibition.jpg'
            ]),
        ];
    }
}