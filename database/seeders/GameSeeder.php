<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            [
                'title' => 'The Legend of Zelda: Breath of the Wild',
                'image' => 'images/games/zelda.jpeg',
                'description' => 'An action-adventure game set in an open world where players control Link who awakens from a hundred-year slumber to defeat Calamity Ganon and save the kingdom of Hyrule.',
                'genre' => 'Action-Adventure',
                'release_year' => 2017,
                'publisher' => 'Nintendo'
            ],
            [
                'title' => 'Elden Ring',
                'image' => 'images/games/elden-ring.jpg',
                'description' => 'An action RPG developed by FromSoftware and published by Bandai Namco Entertainment, created in collaboration with fantasy novelist George R. R. Martin.',
                'genre' => 'Action RPG',
                'release_year' => 2022,
                'publisher' => 'Bandai Namco Entertainment'
            ],
            [
                'title' => 'The Witcher 3: Wild Hunt',
                'image' => 'images/games/witcher.png',
                'description' => 'A story-driven, open world RPG set in a visually stunning fantasy universe full of meaningful choices and impactful consequences.',
                'genre' => 'RPG',
                'release_year' => 2015,
                'publisher' => 'CD Projekt'
            ],
            [
                'title' => 'God of War',
                'image' => 'images/games/gow.jpg',
                'description' => 'His vengeance against the Gods of Olympus years behind him, Kratos now lives as a man in the realm of Norse Gods and monsters. It is in this harsh, unforgiving world that he must fight to survive.',
                'genre' => 'Action-Adventure',
                'release_year' => 2018,
                'publisher' => 'Sony Interactive Entertainment'
            ],
            [
                'title' => 'Cyberpunk 2077',
                'image' => 'images/games/Cyberpunk.jpg',
                'description' => 'An open-world, action-adventure story set in Night City, a megalopolis obsessed with power, glamour and body modification.',
                'genre' => 'RPG',
                'release_year' => 2020,
                'publisher' => 'CD Projekt'
            ],
            [
                'title' => 'Hades',
                'image' => 'images/games/Hades.jpg',
                'description' => 'A rogue-like dungeon crawler in which you defy the god of the dead as you hack and slash your way out of the Underworld of Greek myth.',
                'genre' => 'Roguelike',
                'release_year' => 2020,
                'publisher' => 'Supergiant Games'
            ],
            [
                'title' => 'Hollow Knight',
                'image' => 'images/games/hollow.jpg',
                'description' => 'A challenging 2D action-adventure. Explore twisting caverns, battle tainted creatures and befriend bizarre bugs, all in a classic, hand-drawn style.',
                'genre' => 'Metroidvania',
                'release_year' => 2017,
                'publisher' => 'Team Cherry'
            ],
            [
                'title' => 'Minecraft',
                'image' => 'images/games/Minecraft.jpg',
                'description' => 'A sandbox video game that allows players to build and explore virtual worlds made up of blocks.',
                'genre' => 'Sandbox',
                'release_year' => 2011,
                'publisher' => 'Mojang Studios'
            ],
            [
                'title' => 'Grand Theft Auto V',
                'image' => 'images/games/gta.png',
                'description' => 'An action-adventure game set in the sprawling city of Los Santos and its surrounding areas, following three criminals and their efforts to commit heists while under pressure from a government agency.',
                'genre' => 'Action-Adventure',
                'release_year' => 2013,
                'publisher' => 'Rockstar Games'
            ],
            [
                'title' => 'Stardew Valley',
                'image' => 'images/games/stardew.jpg',
                'description' => 'A farming simulation game that allows players to build and manage their own farm, interact with villagers, and explore caves filled with monsters and treasures.',
                'genre' => 'Simulation',
                'release_year' => 2016,
                'publisher' => 'ConcernedApe'
            ],
            [
                'title' => 'The Last of Us',
                'image' => 'images/games/tlou.jpg',
                'description' => 'The Last of Us is a 2013 action-adventure game developed by Naughty Dog and published by Sony Computer Entertainment. Players control Joel, a smuggler tasked with escorting a teenage girl, Ellie, across a post-apocalyptic United States.',
                'genre' => 'Action, Adventure',
                'release_year' => 2013,
                'publisher' => 'Naughty Dog'
            ]
        ];

        foreach ($games as $game) {
            Game::create($game);
        }
    }
}