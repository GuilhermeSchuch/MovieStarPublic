<?php
    require_once("models/User.php");

    $userModel = new User();
    $fullName = $userModel->getFullName($review->user);

    //Vefiry if user has image
    if($review->user->image == ""){
        $review->user->image = "user.png";
    }
?>

<div class="col-md-12 review">
    <div class="row">
        <div class="col-md-1">
            <div class="profile-image-container review-image" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $review->user->image ?>')"></div>
        </div>

        <div class="col-md-9 author-details-container">
            <h4 class="author-name">
                <a href="<?= $BASE_URL ?>profile.php?id=<?= $review->user->id ?>"><?= $fullName ?></a>
            </h4>
            <p><i class="fas fa-star"></i> <?=$review->rating ?></p>
        </div>

        <div class="col-md-12">
            <p class="comment-title">Comment: </p>
            <p><?= $review->review ?></p>
        </div>

        <div class="col-md-2 editreview">
            <?php if(!empty($userData) && $review->users_id === $userData->id): ?>
                <form action="<?= $BASE_URL ?>editreview.php?id=<?= $movie->id ?>" id="editreview-form" method="post">
                    <input type="submit" value="Edit review" class="btn card-btn btn-editreview">
                </form>
            <?php endif; ?>
        </div>

        <div class="col-md-9 removereview">
            <?php if(!empty($userData) && $review->users_id === $userData->id): ?>
                <form action="<?= $BASE_URL ?>review_process.php" id="removereview-form" method="post">
                    <input type="hidden" name="type" value="delete">
                    <input type="hidden" name="id" value="<?= $review->id ?>">
                    <input type="hidden" name="movies_id" value="<?= $review->movies_id ?>">

                    <input type="submit" value="Remove review" class="btn card-btn btn-removereview">
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>