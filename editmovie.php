<?php
    require_once("templates/header.php");
    require_once("models/User.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");

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

        //Verify if movie exist
        if(!$movie){
            $message->setMessage("Movie not found", "error", "index.php");
        }
    }

    //Verify if Movie has image
    if($movie->image == '' ){
        $movie->image = "movie_cover.jpg";
    }
?>

    <div id="main-container" class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 offset-md-1">
                    <h1><?= $movie->title ?></h1>
                    <p class="page-description">Change Movie data in the form below:</p>

                    <form id="edit-movie-form" action="<?= $BASE_URL ?>movie_process.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="update">
                        <input type="hidden" name="id" value="<?= $movie->id ?>">

                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Movie title" value="<?= $movie->title ?>">
                        </div>

                        <div class="form-group">
                            <label for="image">Image:</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div>

                        <div class="form-group">
                            <label for="length">Length:</label>
                            <input type="text" class="form-control" id="length" name="length" placeholder="Movie Length" value="<?= $movie->length ?>">
                        </div>

                        <div class="form-group">
                            <label for="category">Category:</label>
                            <select class="form-control" id="category" name="category">
                                <option value="">Select a category</option>
                                <option value="Action" <?= $movie->category === "Action" ? "selected" : "" ?>>Action</option>
                                <option value="Adventure" <?= $movie->category === "Adventure" ? "selected" : "" ?>>Adventure</option>
                                <option value="Animation" <?= $movie->category === "Animation" ? "selected" : "" ?>>Animation</option>
                                <option value="Comedy" <?= $movie->category === "Comedy" ? "selected" : "" ?>>Comedy</option>
                                <option value="Crime" <?= $movie->category === "Crime" ? "selected" : "" ?>>Crime</option>
                                <option value="Documentary" <?= $movie->category === "Documentary" ? "selected" : "" ?>>Documentary</option>
                                <option value="Drama" <?= $movie->category === "Drama" ? "selected" : "" ?>>Drama</option>
                                <option value="Family" <?= $movie->category === "Family" ? "selected" : "" ?>>Family</option>
                                <option value="Fantasy" <?= $movie->category === "Fantasy" ? "selected" : "" ?>>Fantasy</option>
                                <option value="History <?= $movie->category === "History" ? "selected" : "" ?>">History</option>
                                <option value="Horror" <?= $movie->category === "Horror" ? "selected" : "" ?>>Horror</option>
                                <option value="Music" <?= $movie->category === "Music" ? "selected" : "" ?>>Music</option>
                                <option value="Mystery" <?= $movie->category === "Mystery" ? "selected" : "" ?>>Mystery</option>
                                <option value="Romance" <?= $movie->category === "Romance" ? "selected" : "" ?>>Romance</option>
                                <option value="Sci-Fi" <?= $movie->category === "Sci-Fi" ? "selected" : "" ?>>Sci-Fi</option>
                                <option value="TV Movie" <?= $movie->category === "TV Movie" ? "selected" : "" ?>>TV Movie</option>
                                <option value="Thriller" <?= $movie->category === "Thriller" ? "selected" : "" ?>>Thriller</option>
                                <option value="War" <?= $movie->category === "War" ? "selected" : "" ?>>War</option>
                                <option value="Western" <?= $movie->category === "Western" ? "selected" : "" ?>>Western</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="trailer">Trailer:</label>
                            <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Movie Trailer Link" value="<?= $movie->trailer ?>">
                        </div>

                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Tell about the Movie"><?= $movie->description ?></textarea>
                        </div>

                        <input type="submit" value="Update Movie" class="btn card-btn">
                    </form>
                </div>

                <div class="col-md-3">
                    <div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $movie->image ?>'); height:400px"></div>
                </div>
            </div>
        </div>
    </div>

<?php
    require_once("templates/footer.php");
?>