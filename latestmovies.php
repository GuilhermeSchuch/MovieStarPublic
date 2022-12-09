<?php
    require_once("templates/header.php");
    require_once("models/Movie.php");
    require_once("dao/MovieDAO.php");
    require_once("dao/ReviewDAO.php");

    $movieDao = new MovieDAO($conn, $BASE_URL);
    $reviewDao = new ReviewDAO($conn, $BASE_URL);

    $movies = $movieDao->getAllLatestMovies();
?>

<div id="main-container" class="container-fluid">
    <h2 class="section-title">Latest Movies</h2>
    <p class="section-description">See the new Movies added</p>

    <div class="movies-container">
        <?php foreach($movies as $movie): ?>
            <?php require("templates/movie_card.php") ?>
        <?php endforeach; ?>

        <?php if(count($movies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
                <div class="main" style="min-height: 100vh;"></div>
        <?php endif; ?>
    </div>

    <?php if(count($movies) <= 5): ?>
                <div class="main" style="min-height: 70vh;"></div>
    <?php endif; ?>

    
<?php
    require_once("templates/footer.php");
?>

