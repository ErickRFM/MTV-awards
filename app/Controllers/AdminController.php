<?php

require_once __DIR__ . '/../Models/Artist.php';
require_once __DIR__ . '/../Models/Album.php';
require_once __DIR__ . '/../Models/Song.php';
require_once __DIR__ . '/../Models/Nomination.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Vote.php';

class AdminController
{
    public function dashboard(): void
    {
        $stats = [
            'artists' => Artist::countAll(),
            'albums' => Album::countAll(),
            'songs' => Song::countAll(),
            'nominations' => Nomination::countAll(),
            'users' => User::countAll(),
            'votes' => Vote::countAll(),
        ];

        $recentNominations = array_slice(Nomination::all(), 0, 5);
        $popularArtists = Artist::top(5);

        require __DIR__ . '/../Views/admin/dashboard.php';
    }
}
