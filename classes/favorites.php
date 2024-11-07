<?php
require_once 'Database.php';
require_once 'Movie.php';

class Favorites {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function addFavorite($movie) {
        $pdo = $this->db->getPDO();
        $stmt = $pdo->prepare("INSERT INTO favorites (title, release_date, synopsis) VALUES (?, ?, ?)");
        $stmt->execute([$movie->title, $movie->releaseDate, $movie->synopsis]);
    }

    public function getFavorites() {
        $pdo = $this->db->getPDO();
        $stmt = $pdo->query("SELECT * FROM favorites");
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Movie');
    }
}
?>
