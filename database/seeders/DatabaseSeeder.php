<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Event::factory(20)
            ->has(\App\Models\Ticket::factory()->count(3))
            ->create()
            ->each(function ($event) {
                $event->tickets->each(function ($ticket) {
                    \App\Models\Sale::factory(rand(5, 20))->create([
                        'ticket_id' => $ticket->id
                    ]);
                });
            });
    }
}