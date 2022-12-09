<?php
    require_once("templates/header.php");
    require_once("dao/MovieDAO.php");

    //Movie DAO
    $movieDao = new MovieDAO($conn, $BASE_URL);

    //Get user search
    $q = filter_input(INPUT_GET, "q");

    $movies = $movieDao->findByTitle($q);
?>

    <div id="main-container" class="container-fluid">
        <h2 class="section-title" id="search-title">Searching for: <span id="search-result"><?= $q ?></span></h2>
        <p class="section-description">Search results</p>

        <div class="movies-container">
            <?php foreach($movies as $movie): ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>

            <?php if(count($movies) === 0): ?>
                <p class="empty-list">There is no movie registered based on your search, <a href="<?= $BASE_URL ?>" class="back-link">Back</a></p>
            <?php endif; ?>
        </div>

        <div id="space"></div>
    </div>

    <style>
        @media((min-height: 600px)) {
            #space{
                min-height: 40vh;
            }
        }

        @media((min-height: 1000px)) {
            #space{
                min-height: 60vh;
            }
        }
    </style>

<?php
    require_once("templates/footer.php");
?>