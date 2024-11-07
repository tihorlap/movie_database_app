<?php
class APIHandler {
    private $apiUrl = "http://www.omdbapi.com/?apikey=" . API_KEY;

    public function searchMovies($query) {
        $url = $this->apiUrl . "&s=" . urlencode($query);
        $response = file_get_contents($url);
        return json_decode($response, true);
    }

    public function getMovieDetails($imdbID) {
        $url = $this->apiUrl . "&i=" . urlencode($imdbID);
        $response = file_get_contents($url);
        return json_decode($response, true);
    }
}
?>
