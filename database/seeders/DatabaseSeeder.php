<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Client;
use App\Models\Clothes;
use App\Models\Event;
use App\Models\Hair;
use App\Models\Look;
use App\Models\Makeup;
use App\Models\Season;
use App\Models\Style;
use App\Models\SupportMessage;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $clients = Client::factory(2);
        $seasons = Season::factory(4);
        $events = Event::factory(10);
        $styles = Style::factory(10);

        $hairs = Hair::factory(10)
            ->has($events)
            ->has($styles);
        $makeups = Makeup::factory(10)
            ->has($events)
            ->has($styles);
        $clothes = Clothes::factory(50)
            ->has($events)
            ->has($styles)
            ->has($seasons);


        Look::factory(10)
            ->has($hairs)
            ->has($makeups)
            ->has($clothes)
            ->create();

        SupportMessage::factory(10)
            ->has($clients);
    }
}
