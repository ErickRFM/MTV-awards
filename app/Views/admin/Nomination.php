class Nomination {
  public static function all() {
    return DB::conn()->query("SELECT * FROM nominations")->fetchAll();
  }

  public static function find($id) {
    $st = DB::conn()->prepare("SELECT * FROM nominations WHERE id=?");
    $st->execute([$id]);
    return $st->fetch();
  }

  public static function create($data) {
    $st = DB::conn()->prepare(
      "INSERT INTO nominations (titulo,categoria,tipo,fecha_inicio,fecha_fin)
       VALUES (?,?,?,?,?)"
    );
    return $st->execute($data);
  }

  public static function delete($id) {
    DB::conn()->prepare("DELETE FROM nominations WHERE id=?")->execute([$id]);
  }
}
