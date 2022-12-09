<?php
    require_once("templates/header.php");
    require_once("models/User.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");
    require_once("dao/ReviewDAO.php");

    $reviewDao = new ReviewDAO($conn, $BASE_URL);

    $user = new User();
    //Verify if user is authenticated
    $userDAO = new UserDAO($conn, $BASE_URL);
    $userData = $userDAO->verifyToken(true);

    $movieDao = new MovieDAO($conn, $BASE_URL);
    $id = filter_input(INPUT_GET, "id");

    if(empty($id)){
        $message->setMessage("Movie not found", "error", "index.php");
    }
    else{
        $movie = $movieDao->findById($id);
        $review = $reviewDao->findByUsersId($userData->id, $id);

        $reviewId = $review->id;
        $userReview = $review->review;
        $userRating = $review->rating;
        
        //Verify if movie exist
        if(!$movie){
            $message->setMessage("Movie not found", "error", "index.php");
        }
    }

    //Verify if Movie has image
    if($movie->image == '' ){
        $movie->image = "movie_cover.jpg";
    }

    $movieReviews = $reviewDao->getMoviesReview($id);

    if(!empty($userData)){
        //Set Movie review
        $alreadyReviewed = $reviewDao->hasAlreadyReviewed($id, $userData->id);
    }
?>

<div id="main-container" class="container-fluid">
<div id="main-container" class="container-fluid">
    <div class="row">
        <div class="offset-md-1 col-md-6 movie-container">
            <h1 class="page-title"><?= $movie->title ?></h1>
            <p class="movie-details">
                <span>Length: <?= $movie->length ?></span>
                <span class="pipe"></span>
                <span><?= $movie->category ?></span>
                <span class="pipe"></span>
                <span><i class="fas fa-star"> <?= $movie->rating ?></i></span>
            </p>

            <iframe id="#iframe-trailer" width="560" height="315" src="<?= $movie->trailer ?>" 
                title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; 
                clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

            <p><?= $movie->description ?></p>
        </div>

        <div class="col-md-4">
            <div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $movie->image ?>');"></div>
        </div>

        <div class="offset-md-1 col-md-10 scroll" id="reviews-container">
            <h3 id="reviews-title">Reviews: </h3>

            <!-- Verify if enable review to user -->
            <?php if(!empty($userData)): ?>
            <div class="col-md-12" id="review-form-container">
                <h4>Send your review: </h4>
                <p class="description">Fill the form below about the Movie</p>

                <form action="<?= $BASE_URL ?>review_process.php" id="review-form" method="post">
                    <input type="hidden" name="type" value="update">
                    <input type="hidden" name="id" value="<?= $reviewId ?>">
                    <input type="hidden" name="movies_id" value="<?= $movie->id ?>">

                    <div class="form-group">
                        <label for="rating">Rating: </label>
                        <select name="rating" id="rating" class="form-control">
                            <option value="">Select Rating</option>
                            <?php for($i = 10; $i >= 1; $i--): ?>
                                <?php if($i == $userRating): ?>
                                    <option value="<?= $i ?>" selected><?= $i ?></option>
                                <?php else: ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="review">Your review: </label>
                        <textarea name="review" id="review" rows="3" class="form-control" placeholder="Tell about the Movie"><?= $userReview ?></textarea>
                    </div>
                    <input type="submit" value="Send review" class="btn card-btn">
                </form>
            </div>

            <?php endif; ?>

            <!-- Comments -->
            <?php foreach($movieReviews as $review): ?>

                <?php if($review->users_id === $userData->id): ?>
                
                <?php else: ?>
                    <?php require("user_review.php"); ?>
                <?php endif; ?>

            <?php endforeach; ?>

            <?php if(count($movieReviews) === 0): ?>
                <p class="empty-list">There is no review yet...</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
    require_once("templates/footer.php");
?>