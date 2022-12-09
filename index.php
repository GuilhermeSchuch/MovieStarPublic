<?php
    require_once("templates/header.php");
    require_once("dao/MovieDAO.php");

    //Movie DAO
    $movieDAO = new MovieDAO($conn, $BASE_URL);

    $latestMovies = $movieDAO->getLatestMovies();
    $actionMovies = $movieDAO->getMoviesByCategory("action");
    $adventureMovies = $movieDAO->getMoviesByCategory("adventure");
    $animationMovies = $movieDAO->getMoviesByCategory("animation");
    $comedyMovies = $movieDAO->getMoviesByCategory("comedy");
    $crimeMovies = $movieDAO->getMoviesByCategory("crime");
    $documentaryMovies = $movieDAO->getMoviesByCategory("documentary");
    $dramaMovies = $movieDAO->getMoviesByCategory("drama");
    $familyMovies = $movieDAO->getMoviesByCategory("family");
    $fantasyMovies = $movieDAO->getMoviesByCategory("fantasy");
    $historyMovies = $movieDAO->getMoviesByCategory("history");
    $horrorMovies = $movieDAO->getMoviesByCategory("horror");
    $musicMovies = $movieDAO->getMoviesByCategory("music");
    $mysteryMovies = $movieDAO->getMoviesByCategory("mystery");
    $romanceMovies = $movieDAO->getMoviesByCategory("romance");
    $scifiMovies = $movieDAO->getMoviesByCategory("sci-fi");
    $thrillerMovies = $movieDAO->getMoviesByCategory("thriller");
    $warMovies = $movieDAO->getMoviesByCategory("war");
    $westernMovies = $movieDAO->getMoviesByCategory("western");
?>

    <div id="main-container" class="container-fluid">
        <h2 class="section-title"><a href="<?php $BASE_URL ?>latestmovies.php" style="color:white;">New Movies</a></h2>
        <p class="section-description">See the new movies added to MovieStar</p>

        <div class="movies-container">
            <?php foreach($latestMovies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($latestMovies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title"><a href="<?php $BASE_URL ?>category.php?id=action" style="color:white;">Action</a></h2>
        <p class="section-description">See the best Action Movies</p>

        <div class="movies-container">
            <?php foreach($actionMovies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($actionMovies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title"><a href="<?php $BASE_URL ?>category.php?id=adventure" style="color:white;">Adventure</a></h2>
        <p class="section-description">See the best Adventure Movies</p>

        <div class="movies-container">
            <?php foreach($adventureMovies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($adventureMovies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title"><a href="<?php $BASE_URL ?>category.php?id=animation" style="color:white;">Animation</a></h2>
        <p class="section-description">See the best Animation Movies</p>

        <div class="movies-container">
            <?php foreach($animationMovies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($animationMovies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title"><a href="<?php $BASE_URL ?>category.php?id=comedy" style="color:white;">Comedy</a></h2>
        <p class="section-description">See the best Comedy Movies</p>

        <div class="movies-container">
            <?php foreach($comedyMovies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($comedyMovies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title"><a href="<?php $BASE_URL ?>category.php?id=crime" style="color:white;">Crime</a></h2>
        <p class="section-description">See the best Crime Movies</p>

        <div class="movies-container">
            <?php foreach($crimeMovies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($crimeMovies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title"><a href="<?php $BASE_URL ?>category.php?id=documentary" style="color:white;">Documentary</a></h2>
        <p class="section-description">See the best Documentary Movies</p>

        <div class="movies-container">
            <?php foreach($documentaryMovies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($documentaryMovies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title"><a href="<?php $BASE_URL ?>category.php?id=drama" style="color:white;">Drama</a></h2>
        <p class="section-description">See the best Drama Movies</p>

        <div class="movies-container">
            <?php foreach($dramaMovies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($dramaMovies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title"><a href="<?php $BASE_URL ?>category.php?id=family" style="color:white;">Family</a></h2>
        <p class="section-description">See the best Family Movies</p>

        <div class="movies-container">
            <?php foreach($familyMovies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($familyMovies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title"><a href="<?php $BASE_URL ?>category.php?id=fantasy" style="color:white;">Fantasy</a></h2>
        <p class="section-description">See the best Fantasy Movies</p>

        <div class="movies-container">
            <?php foreach($fantasyMovies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($fantasyMovies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title"><a href="<?php $BASE_URL ?>category.php?id=history" style="color:white;">History</a></h2>
        <p class="section-description">See the best History Movies</p>

        <div class="movies-container">
            <?php foreach($historyMovies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($historyMovies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title"><a href="<?php $BASE_URL ?>category.php?id=horror" style="color:white;">Horror</a></h2>
        <p class="section-description">See the best Horror Movies</p>

        <div class="movies-container">
            <?php foreach($horrorMovies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($horrorMovies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title"><a href="<?php $BASE_URL ?>category.php?id=music" style="color:white;">Music</a></h2>
        <p class="section-description">See the best Music Movies</p>

        <div class="movies-container">
            <?php foreach($musicMovies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($musicMovies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title"><a href="<?php $BASE_URL ?>category.php?id=mystery" style="color:white;">Mystery</a></h2>
        <p class="section-description">See the best Mystery Movies</p>

        <div class="movies-container">
            <?php foreach($mysteryMovies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($mysteryMovies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title"><a href="<?php $BASE_URL ?>category.php?id=romance" style="color:white;">Romance</a></h2>
        <p class="section-description">See the best Romance Movies</p>

        <div class="movies-container">
            <?php foreach($romanceMovies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($romanceMovies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title"><a href="<?php $BASE_URL ?>category.php?id=sci-fi" style="color:white;">Sci-Fi</a></h2>
        <p class="section-description">See the best Sci-Fi Movies</p>

        <div class="movies-container">
            <?php foreach($scifiMovies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($scifiMovies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title"><a href="<?php $BASE_URL ?>category.php?id=thriller" style="color:white;">Thriller</a></h2>
        <p class="section-description">See the best Thriller Movies</p>

        <div class="movies-container">
            <?php foreach($thrillerMovies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($thrillerMovies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title"><a href="<?php $BASE_URL ?>category.php?id=war" style="color:white;">War</a></h2>
        <p class="section-description">See the best War Movies</p>

        <div class="movies-container">
            <?php foreach($warMovies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($warMovies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title"><a href="<?php $BASE_URL ?>category.php?id=western" style="color:white;">Western</a></h2>
        <p class="section-description">See the best Western Movies</p>

        <div class="movies-container">
            <?php foreach($westernMovies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($westernMovies) === 0): ?>
                <p class="empty-list">There is no movie registered yet</p>
            <?php endif; ?>
        </div>
    </div>



<?php
    require_once("templates/footer.php");
?>