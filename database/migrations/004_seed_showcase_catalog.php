<?php

return static function (PDO $pdo): void {
    $artists = [
        [
            'name' => 'Bad Bunny',
            'pseudonym' => 'Benito',
            'sex' => 'M',
            'nationality' => 'Puerto Rico',
            'biography' => 'Figura central del catalogo urbano-latino con presencia fuerte en charts, portadas y directos.',
            'photo' => 'uploads/artists/badbunny.jpg',
            'song_cover' => 'uploads/songs/badbunny.jpg',
        ],
        [
            'name' => 'Fuerza Regida',
            'pseudonym' => 'FR',
            'sex' => 'Group',
            'nationality' => 'Mexico',
            'biography' => 'Proyecto de regional mexicano con energia de arena, corridos y visuales directos para el showcase.',
            'photo' => 'uploads/artists/fuerzaregida.jpg',
            'song_cover' => 'uploads/songs/fuerzaregida.jpg',
        ],
        [
            'name' => 'Imagine Dragons',
            'pseudonym' => 'ID',
            'sex' => 'Group',
            'nationality' => 'United States',
            'biography' => 'Banda de rock alternativo con himnos de estadio, sintetizadores amplios y gran impacto visual.',
            'photo' => 'uploads/artists/imaginedragons.jpg',
            'song_cover' => 'uploads/songs/imaginedragons.jpg',
        ],
        [
            'name' => 'Peso Pluma',
            'pseudonym' => 'Doble P',
            'sex' => 'M',
            'nationality' => 'Mexico',
            'biography' => 'Voz clave del sonido mexicano contemporaneo con identidad propia y gran traccion en streaming.',
            'photo' => 'uploads/artists/pesopluma.jpg',
            'song_cover' => 'uploads/songs/pesopluma.jpg',
        ],
        [
            'name' => 'Romeo Santos',
            'pseudonym' => 'King of Bachata',
            'sex' => 'M',
            'nationality' => 'Dominican Republic',
            'biography' => 'Referente de la bachata-pop con catalogo elegante, romantico y perfecto para una vitrina musical.',
            'photo' => 'uploads/artists/romeo_santos.jpg',
            'song_cover' => 'uploads/songs/romeo_santos.jpg',
        ],
        [
            'name' => 'Selena Gomez',
            'pseudonym' => 'Selena',
            'sex' => 'F',
            'nationality' => 'United States',
            'biography' => 'Artista pop con eras visuales muy claras, ideal para mostrar tarjetas y portadas en la interfaz.',
            'photo' => 'uploads/artists/selena_gomez.jpg',
            'song_cover' => 'uploads/songs/selena_gomez.jpg',
        ],
        [
            'name' => 'Shakira',
            'pseudonym' => 'Shak',
            'sex' => 'F',
            'nationality' => 'Colombia',
            'biography' => 'Icono global latino con mezcla de pop, rock y ritmos tropicales que elevan el tono del portal.',
            'photo' => 'uploads/artists/shakira.jpg',
            'song_cover' => 'uploads/songs/shakira.jpg',
        ],
        [
            'name' => 'The Weeknd',
            'pseudonym' => 'Abel',
            'sex' => 'M',
            'nationality' => 'Canada',
            'biography' => 'Proyecto pop nocturno con estandar visual fuerte, tonos cinematicos y portadas muy reconocibles.',
            'photo' => 'uploads/artists/the_weeknd.png',
            'song_cover' => 'uploads/songs/the_weeknd.png',
        ],
        [
            'name' => 'Tito Double P',
            'pseudonym' => 'TDP',
            'sex' => 'M',
            'nationality' => 'Mexico',
            'biography' => 'Nueva cara del regional con energia fresca, colaboraciones grandes y visuales listos para admin.',
            'photo' => 'uploads/artists/titodoublep.jpg',
            'song_cover' => 'uploads/songs/titodoublep.jpg',
        ],
    ];

    $albums = [
        ['artist' => 'The Weeknd', 'title' => 'After Hours', 'cover' => 'uploads/albums/after_hours.jpg', 'release_date' => '2020-03-20', 'genre_id' => 1, 'track' => 'Blinding Lights'],
        ['artist' => 'Tito Double P', 'title' => 'Ahy Que?', 'cover' => 'uploads/albums/ahyque.jpg', 'release_date' => '2024-07-12', 'genre_id' => 5, 'track' => 'Ahy Que Va'],
        ['artist' => 'Fuerza Regida', 'title' => 'Baby Belikeada', 'cover' => 'uploads/albums/baby_belikeada.jpg', 'release_date' => '2023-12-15', 'genre_id' => 5, 'track' => 'Belikeada Mode'],
        ['artist' => 'Fuerza Regida', 'title' => 'Barrio Vol. 2', 'cover' => 'uploads/albums/barrio_vol2.jpg', 'release_date' => '2022-10-21', 'genre_id' => 5, 'track' => 'Codigo de Barrio'],
        ['artist' => 'The Weeknd', 'title' => 'Beauty Behind the Madness', 'cover' => 'uploads/albums/beauty_behind_madness.jpg', 'release_date' => '2015-08-28', 'genre_id' => 1, 'track' => 'Cant Feel My Face'],
        ['artist' => 'The Weeknd', 'title' => 'Beauty & Madness Sessions', 'cover' => 'uploads/albums/beauty_madness.jpg', 'release_date' => '2016-02-19', 'genre_id' => 1, 'track' => 'Midnight Echo'],
        ['artist' => 'Tito Double P', 'title' => 'Better Late Than Never', 'cover' => 'uploads/albums/better_late_than_never.jpg', 'release_date' => '2024-01-26', 'genre_id' => 5, 'track' => 'Llegue Tarde Pero Bien'],
        ['artist' => 'Romeo Santos', 'title' => 'Efectos Secundarios', 'cover' => 'uploads/albums/efectos_secundarios.jpg', 'release_date' => '2019-06-14', 'genre_id' => 6, 'track' => 'Bachata en el Aire'],
        ['artist' => 'Imagine Dragons', 'title' => 'Evolve', 'cover' => 'uploads/albums/evolve.jpg', 'release_date' => '2017-06-23', 'genre_id' => 2, 'track' => 'Believer'],
        ['artist' => 'Shakira', 'title' => 'Fijacion Oral Vol. 1', 'cover' => 'uploads/albums/fijacion_oral_vol1.jpg', 'release_date' => '2005-06-03', 'genre_id' => 6, 'track' => 'La Tortura'],
        ['artist' => 'Romeo Santos', 'title' => 'Formula Vol. 2', 'cover' => 'uploads/albums/formula_vol2.jpg', 'release_date' => '2014-02-25', 'genre_id' => 6, 'track' => 'Propuesta Indecente'],
        ['artist' => 'Romeo Santos', 'title' => 'Formula Vol. 3', 'cover' => 'uploads/albums/formula_vol3.jpg', 'release_date' => '2022-09-01', 'genre_id' => 6, 'track' => 'Sus Huellas'],
        ['artist' => 'Peso Pluma', 'title' => 'Genesis', 'cover' => 'uploads/albums/genesis.jpg', 'release_date' => '2023-06-29', 'genre_id' => 5, 'track' => 'Luna'],
        ['artist' => 'The Weeknd', 'title' => 'Kiss Land', 'cover' => 'uploads/albums/kiss_land.jpg', 'release_date' => '2013-09-10', 'genre_id' => 1, 'track' => 'Live For'],
        ['artist' => 'Selena Gomez', 'title' => 'Kiss & Tell', 'cover' => 'uploads/albums/kiss_tell.jpg', 'release_date' => '2009-09-29', 'genre_id' => 1, 'track' => 'Naturally'],
        ['artist' => 'Shakira', 'title' => 'Laundry Service', 'cover' => 'uploads/albums/laundry_service.jpg', 'release_date' => '2001-11-13', 'genre_id' => 6, 'track' => 'Whenever Wherever'],
        ['artist' => 'Tito Double P', 'title' => 'Los Cuadros', 'cover' => 'uploads/albums/los_cuadros.jpg', 'release_date' => '2023-09-08', 'genre_id' => 5, 'track' => 'Doble Trazo'],
        ['artist' => 'Imagine Dragons', 'title' => 'Mercury Act 1', 'cover' => 'uploads/albums/mercury_act1.jpg', 'release_date' => '2021-09-03', 'genre_id' => 2, 'track' => 'Wrecked'],
        ['artist' => 'Bad Bunny', 'title' => 'Nadie Sabe Lo Que Va a Pasar Manana', 'cover' => 'uploads/albums/nadiesabe.jpg', 'release_date' => '2023-10-13', 'genre_id' => 3, 'track' => 'Monaco'],
        ['artist' => 'Imagine Dragons', 'title' => 'Night Visions', 'cover' => 'uploads/albums/night_visions.jpg', 'release_date' => '2012-09-04', 'genre_id' => 2, 'track' => 'Radioactive'],
        ['artist' => 'Fuerza Regida', 'title' => 'Otro Nivel', 'cover' => 'uploads/albums/otro_nivel.jpg', 'release_date' => '2021-05-14', 'genre_id' => 5, 'track' => 'Nivel de Calle'],
        ['artist' => 'Fuerza Regida', 'title' => 'Puro Raza', 'cover' => 'uploads/albums/puro_raza.jpg', 'release_date' => '2020-08-28', 'genre_id' => 5, 'track' => 'Compa de Honor'],
        ['artist' => 'Selena Gomez', 'title' => 'Revival', 'cover' => 'uploads/albums/revival.jpg', 'release_date' => '2015-10-09', 'genre_id' => 1, 'track' => 'Hands to Myself'],
        ['artist' => 'Selena Gomez', 'title' => 'Revival Tour Edition', 'cover' => 'uploads/albums/revival_album.jpg', 'release_date' => '2016-05-06', 'genre_id' => 1, 'track' => 'Same Old Love'],
        ['artist' => 'Shakira', 'title' => 'Shakira.', 'cover' => 'uploads/albums/shakira_album.jpg', 'release_date' => '2014-03-21', 'genre_id' => 6, 'track' => 'Empire'],
        ['artist' => 'Shakira', 'title' => 'She Wolf', 'cover' => 'uploads/albums/she_wolf.jpg', 'release_date' => '2009-10-09', 'genre_id' => 6, 'track' => 'Loba'],
        ['artist' => 'Selena Gomez', 'title' => 'Stars Dance', 'cover' => 'uploads/albums/stars_dance.jpg', 'release_date' => '2013-07-19', 'genre_id' => 1, 'track' => 'Come & Get It'],
        ['artist' => 'The Weeknd', 'title' => 'Utopia Nights', 'cover' => 'uploads/albums/utopia.jpg', 'release_date' => '2024-04-05', 'genre_id' => 1, 'track' => 'Neon Escape'],
        ['artist' => 'Bad Bunny', 'title' => 'Un Verano Sin Ti', 'cover' => 'uploads/albums/verano.jpg', 'release_date' => '2022-05-06', 'genre_id' => 6, 'track' => 'Me Porto Bonito'],
        ['artist' => 'Romeo Santos', 'title' => 'Vida Una', 'cover' => 'uploads/albums/vida_una.jpg', 'release_date' => '2024-02-02', 'genre_id' => 6, 'track' => 'Solo Conmigo'],
        ['artist' => 'Bad Bunny', 'title' => 'YHLQMDLG', 'cover' => 'uploads/albums/yhlqmdlg.jpg', 'release_date' => '2020-02-29', 'genre_id' => 3, 'track' => 'Safaera'],
    ];

    $artistIds = [];
    $songCoverByArtist = [];

    $findArtistId = $pdo->prepare('SELECT id FROM artists WHERE name = :name LIMIT 1');
    $insertArtist = $pdo->prepare("
        INSERT INTO artists (name, pseudonym, sex, nationality, biography, photo, status)
        VALUES (:name, :pseudonym, :sex, :nationality, :biography, :photo, 1)
    ");
    $updateArtist = $pdo->prepare("
        UPDATE artists
        SET pseudonym = :pseudonym,
            sex = :sex,
            nationality = :nationality,
            biography = :biography,
            photo = :photo,
            status = 1
        WHERE id = :id
    ");

    $findAlbumId = $pdo->prepare('SELECT id FROM albums WHERE artist_id = :artist_id AND title = :title LIMIT 1');
    $insertAlbum = $pdo->prepare("
        INSERT INTO albums (artist_id, title, release_date, description, cover, genre_id)
        VALUES (:artist_id, :title, :release_date, :description, :cover, :genre_id)
    ");
    $updateAlbum = $pdo->prepare("
        UPDATE albums
        SET release_date = :release_date,
            description = :description,
            cover = :cover,
            genre_id = :genre_id
        WHERE id = :id
    ");

    $findSongId = $pdo->prepare('SELECT id FROM songs WHERE album_id = :album_id AND title = :title LIMIT 1');
    $insertSong = $pdo->prepare("
        INSERT INTO songs (album_id, title, cover, release_date, genre_id, mp3_url, video_url)
        VALUES (:album_id, :title, :cover, :release_date, :genre_id, :mp3_url, :video_url)
    ");
    $updateSong = $pdo->prepare("
        UPDATE songs
        SET cover = :cover,
            release_date = :release_date,
            genre_id = :genre_id,
            mp3_url = :mp3_url,
            video_url = :video_url
        WHERE id = :id
    ");

    $pdo->beginTransaction();

    try {
        foreach ($artists as $artist) {
            $findArtistId->execute(['name' => $artist['name']]);
            $artistId = (int) $findArtistId->fetchColumn();

            if ($artistId > 0) {
                $updateArtist->execute([
                    'id' => $artistId,
                    'pseudonym' => $artist['pseudonym'],
                    'sex' => $artist['sex'],
                    'nationality' => $artist['nationality'],
                    'biography' => $artist['biography'],
                    'photo' => $artist['photo'],
                ]);
            } else {
                $insertArtist->execute([
                    'name' => $artist['name'],
                    'pseudonym' => $artist['pseudonym'],
                    'sex' => $artist['sex'],
                    'nationality' => $artist['nationality'],
                    'biography' => $artist['biography'],
                    'photo' => $artist['photo'],
                ]);
                $artistId = (int) $pdo->lastInsertId();
            }

            $artistIds[$artist['name']] = $artistId;
            $songCoverByArtist[$artist['name']] = $artist['song_cover'];
        }

        foreach ($albums as $album) {
            $artistId = (int) ($artistIds[$album['artist']] ?? 0);
            if ($artistId === 0) {
                continue;
            }

            $description = $album['title'] . ' llega al catalogo MTV Awards con portada local, artista enlazado y presencia lista para demos y despliegues.';

            $findAlbumId->execute([
                'artist_id' => $artistId,
                'title' => $album['title'],
            ]);
            $albumId = (int) $findAlbumId->fetchColumn();

            if ($albumId > 0) {
                $updateAlbum->execute([
                    'id' => $albumId,
                    'release_date' => $album['release_date'],
                    'description' => $description,
                    'cover' => $album['cover'],
                    'genre_id' => $album['genre_id'],
                ]);
            } else {
                $insertAlbum->execute([
                    'artist_id' => $artistId,
                    'title' => $album['title'],
                    'release_date' => $album['release_date'],
                    'description' => $description,
                    'cover' => $album['cover'],
                    'genre_id' => $album['genre_id'],
                ]);
                $albumId = (int) $pdo->lastInsertId();
            }

            $songData = [
                'album_id' => $albumId,
                'title' => $album['track'],
                'cover' => $songCoverByArtist[$album['artist']] ?? null,
                'release_date' => $album['release_date'],
                'genre_id' => $album['genre_id'],
                'mp3_url' => null,
                'video_url' => null,
            ];

            $findSongId->execute([
                'album_id' => $albumId,
                'title' => $songData['title'],
            ]);
            $songId = (int) $findSongId->fetchColumn();

            if ($songId > 0) {
                $updateSong->execute([
                    'id' => $songId,
                    'cover' => $songData['cover'],
                    'release_date' => $songData['release_date'],
                    'genre_id' => $songData['genre_id'],
                    'mp3_url' => $songData['mp3_url'],
                    'video_url' => $songData['video_url'],
                ]);
            } else {
                $insertSong->execute($songData);
            }
        }

        $pdo->commit();
    } catch (Throwable $exception) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        throw $exception;
    }
};
