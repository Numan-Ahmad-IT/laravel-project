<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\Sale;
use Illuminate\Database\Seeder;

class EventTicketSalesSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        Sale::query()->delete();
        Ticket::query()->delete();
        Event::query()->delete();

        // Create exactly 20 events
        $events = Event::factory()
            ->count(20)
            ->create();

        // For each event, create 2-4 tickets
        $events->each(function ($event) {
            $tickets = Ticket::factory()
                ->count(rand(2, 4))
                ->create(['event_id' => $event->id]);

            // For each ticket, create 1-5 sales
            $tickets->each(function ($ticket) {
                Sale::factory()
                    ->count(rand(1, 5))
                    ->create(['ticket_id' => $ticket->id]);
            });
        });

        $this->command->info('Successfully seeded 20 events with related tickets and sales!');
    }
}