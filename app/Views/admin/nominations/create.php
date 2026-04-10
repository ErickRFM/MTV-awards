<?php
require_once __DIR__ . '/../Models/Song.php';
require_once __DIR__ . '/../Models/Artist.php';
require_once __DIR__ . '/../Models/Album.php';

class SongController {

    // LISTADO
    public function index() {
        $song = new Song();
        $songs = $song->all();
        require __DIR__ . '/../Views/admin/songs/list.php';
    }

    // FORM CREAR
    public function createForm() {
        $artist = new Artist();
        $album  = new Album();

        $artists = $artist->all();
        $albums  = $album->all();

        require __DIR__ . '/../Views/admin/songs/create.php';
    }

    // GUARDAR
    public function store() {
        $song = new Song();
        $song->create($_POST);

        header("Location: /admin/songs");
        exit;
    }

    // FORM EDITAR
    public function editForm($id) {
        $song   = new Song();
        $artist = new Artist();
        $album  = new Album();

        $songData = $song->find($id);
        $artists  = $artist->all();
        $albums   = $album->all();

        require __DIR__ . '/../Views/admin/songs/edit.php';
    }

    // ACTUALIZAR
    public function update($id) {
        $song = new Song();
        $song->update($id, $_POST);

        header("Location: /admin/songs");
        exit;
    }

    // ELIMINAR
    public function delete($id) {
        $song = new Song();
        $song->delete($id);

        header("Location: /admin/songs");
        exit;
    }
}
