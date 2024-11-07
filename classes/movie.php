<?php
class Movie {
    public $title;
    public $releaseDate;
    public $synopsis;

    public function __construct($title, $releaseDate, $synopsis) {
        $this->title = $title;
        $this->releaseDate = $releaseDate;
        $this->synopsis = $synopsis;
    }
}
?>
