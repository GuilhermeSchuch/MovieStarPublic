<?php
    if(empty($movie->image)){
        $movie->image = "movie_cover.jpg";
    }
?>

<div class="card movie-card">
    <div class="card-img-top" style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $movie->image ?>');"></div>

    <div class="card-body">
        <p class="card-rating">
            <i class="fas fa-star"></i>
            <span class="rating"><?= $movie->rating ?></span>
        </p>
        <h5 class="card-title">
            <?php if(!strlen($movie->title) >= 26): ?>
                <a href="<?= $BASE_URL ?>movie.php?id=<?= $movie->id ?>"><?= $movie->title ?></a>
            <?php else: ?>
                <a href="<?= $BASE_URL ?>movie.php?id=<?= $movie->id ?>"><?= mb_strimwidth($movie->title, 0, 25, "...") ?></a>
            <?php endif; ?>
        </h5>
        <a id="rate" href="<?= $BASE_URL ?>movie.php?id=<?= $movie->id ?>&r=t" class="btn btn-primary rate-btn">Rate</a>
        <a href="<?= $BASE_URL ?>movie.php?id=<?= $movie->id ?>" class="btn btn-primary card-btn">See more</a>
    </div>
</div>