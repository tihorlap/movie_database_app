<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Database App</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="#">MovieDB</a>
            
            <!-- Toggler for mobile view -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-5">
        <h1 class="text-center">Movie Database App</h1>
        
        <!-- Search Form -->
        <form method="GET" action="index.php" class="form-inline my-4 justify-content-center">
            <input type="text" name="query" class="form-control mr-2" placeholder="Search for a movie" required>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <!-- Display Movies -->
        <?php
        require_once 'config.php';
        require_once 'classes/APIHandler.php';
        require_once 'classes/Favorites.php';

        if (isset($_GET['query'])) {
            $apiHandler = new APIHandler();
            $movies = $apiHandler->searchMovies($_GET['query']);

            if ($movies && $movies['Response'] == "True") {
                echo '<div class="row">';
                foreach ($movies['Search'] as $movieData) {
                    $movieDetails = $apiHandler->getMovieDetails($movieData['imdbID']);
                    $movie = new Movie($movieDetails['Title'], $movieDetails['Released'], $movieDetails['Plot']);
                    echo '
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">' . htmlspecialchars($movie->title) . '</h5>
                                <p class="card-text"><strong>Release Date:</strong> ' . htmlspecialchars($movie->releaseDate) . '</p>
                                <p class="card-text"><strong>Synopsis:</strong> ' . htmlspecialchars($movie->synopsis) . '</p>
                                <form method="POST" action="index.php">
                                    <input type="hidden" name="title" value="' . htmlspecialchars($movie->title) . '">
                                    <input type="hidden" name="release_date" value="' . htmlspecialchars($movie->releaseDate) . '">
                                    <input type="hidden" name="synopsis" value="' . htmlspecialchars($movie->synopsis) . '">
                                    <button type="submit" class="btn btn-success" name="save_favorite">Save as Favorite</button>
                                </form>
                            </div>
                        </div>
                    </div>';
                }
                echo '</div>';
            } else {
                echo '<p class="text-danger text-center">No movies found.</p>';
            }
        }

        // Handle saving a favorite movie
        if (isset($_POST['save_favorite'])) {
            $favorites = new Favorites();
            $movie = new Movie($_POST['title'], $_POST['release_date'], $_POST['synopsis']);
            $favorites->addFavorite($movie);
            echo '<p class="text-success text-center">Movie added to favorites!</p>';
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
