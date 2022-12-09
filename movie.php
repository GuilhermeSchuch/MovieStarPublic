<?php
    require_once("templates/header.php");
    require_once("models/Movie.php");
    require_once("dao/MovieDAO.php");
    require_once("dao/ReviewDAO.php");

    // Get Movie by Id
    $id = filter_input(INPUT_GET, "id");
    
    $movie;

    $movieDao = new MovieDAO($conn, $BASE_URL);
    $reviewDao = new ReviewDAO($conn, $BASE_URL);

    if(empty($id)){
        $message->setMessage("Movie not found", "error", "index.php");
    }
    else{
        $movie = $movieDao->findById($id);

        //Verify if movie exist
        if(!$movie){
            $message->setMessage("Movie not found", "error", "index.php");
        }
    }

    //Verify if Movie has image
    if($movie->image == '' ){
        $movie->image = "movie_cover.jpg";
    }

    if(!empty($userData)){
        //Set Movie review
        $alreadyReviewed = $reviewDao->hasAlreadyReviewed($id, $userData->id);
    }

    //Get Movie review
    $movieReviews = $reviewDao->getMoviesReview($id);

    //Get age restriction
    $urlTitle = strtolower($movie->title);
    $urlTitle = str_replace(" ", "+", $urlTitle);

    $url = "http://www.omdbapi.com/?apikey=c7e49ea1&t=" . $urlTitle;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = json_decode(curl_exec($ch));

    if($result->Response == "True"){
        $ageRestriction = $result->Rated;
    }
    else{
        $ageRestriction = null;
    }

    //Add icon to the Movie Page
    function addIcon($value){
        if($value == "TV-MA" or $value == "R" or $value == "NR" or $value == "NC-17"){
            // return "img\\ageRestriction icons\\18.png";
            echo "<img src='img\\ageRestriction icons\\18.png' alt='' style='width:40px;height:40px;'>";
        }
        elseif($value == "TV-14"){
            // return "img\\ageRestriction icons\\16.png";
            echo "<img src='img\\ageRestriction icons\\16.png' alt='' style='width:40px;height:40px;'>";
        }
        elseif($value == "PG-13"){
            // return "img\\ageRestriction icons\\13.png";
            echo "<img src='img\\ageRestriction icons\\13.png' alt='' style='width:40px;height:40px;'>";
        }
        elseif($value == "PG" or $value == "TV-Y7" or $value == "TV-Y7-FV" or $value == "TV-PG"){
            // return "img\\ageRestriction icons\\10.png";
            echo "<img src='img\\ageRestriction icons\\10.png' alt='' style='width:40px;height:40px;'>";
        }
        elseif($value == "G" or $value == "TV-G" or $value == "TV-Y"){
            // return "img\\ageRestriction icons\\0.png";
            echo "<img src='img\\ageRestriction icons\\0.png' alt='' style='width:40px;height:40px;'>";
        }
        else{
            return '';
        }
    }

?>

<div id="main-container" class="container-fluid">
    <div class="row">
        <div class="offset-md-1 col-md-6 movie-container">
            <h1 class="page-title"><?= $movie->title ?></h1>
            <p class="movie-details">
                <span>Length: <?= $movie->length ?></span>
                <span class="pipe"></span>
                <span><a href="<?= $BASE_URL . "category.php?id=$movie->category"?>"><?= $movie->category ?></a></span>
                <span class="pipe"></span>
                <span><i class="fas fa-star"> <?= $movie->rating ?></i></span>
                <?php if($ageRestriction != null): ?>
                    <span class="pipe"></span>
                    <span><?= addIcon($ageRestriction) ?></span>
                <?php endif ;?>
            </p>

            <iframe id="#iframe-trailer" width="560" height="315" src="<?= $movie->trailer ?>" 
                title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; 
                clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <p><?= $movie->description ?></p>
            
            <p id="posted_by">Posted by: <a href="<?= $BASE_URL ?>profile.php?id=<?= $movieDao->getUserIdByMovieId($movie->id)["id"] ?>"><?=$movieDao->getUserNameByMovieId($movie->id)?></a></p>
        </div>

        <div class="col-md-4">
            <div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $movie->image ?>');"></div>
        </div>

        <div class="offset-md-1 col-md-10" id="reviews-container">
            
        <?php if(substr($_GET["r"], -1) == 't'): ?>
            <div class="scroll"></div>
        <?php endif; ?>
            <h3 id="reviews-title">Reviews: </h3>

            <!-- Verify if enable review to user -->
            <?php if(!empty($userData) && !$alreadyReviewed): ?>
            <div class="col-md-12" id="review-form-container">

                <h4>Send your review: </h4>
                <p class="description">Fill the form below about the Movie</p>

                <form action="<?= $BASE_URL ?>review_process.php" id="review-form" method="post">
                    <input type="hidden" name="type" value="create">
                    <input type="hidden" name="movies_id" value="<?= $movie->id ?>">

                    <div class="form-group">
                        <label for="rating">Rating: </label>
                        <select name="rating" id="rating" class="form-control">
                            <option value="">Select Rating</option>
                            <option value="10">10</option>
                            <option value="9">9</option>
                            <option value="8">8</option>
                            <option value="7">7</option>
                            <option value="6">6</option>
                            <option value="5">5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="review">Your review: </label>
                        <textarea name="review" id="review" rows="3" class="form-control" placeholder="Tell about the Movie"></textarea>
                    </div>
                    <input type="submit" value="Send review" class="btn card-btn">
                </form>
            </div>

            <?php endif; ?>
            <!-- Comments -->
            <?php foreach($movieReviews as $review): ?>
                <?php require("user_review.php"); ?>
            <?php endforeach; ?>

            <?php if(count($movieReviews) === 0): ?>
                <p class="empty-list">There is no review yet...</p>
                <div id="space"></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    @media((min-height: 1000px)) {
        #space{
            min-height: 25vh;
        }
    }
</style>

<?php
    require_once("templates/footer.php");
?>