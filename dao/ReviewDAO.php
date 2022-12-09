<?php
    require_once("models/Review.php");
    require_once("models/Message.php");

    Class ReviewDao implements ReviewDAOInterface{
        private $conn;
        private $url;
        private $message;
        

        public function __construct(PDO $conn, $url){
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildReview($data){
            $reviewObject = new Review();

            $reviewObject->id = $data["id"];
            $reviewObject->rating = $data["rating"];
            $reviewObject->review = utf8_encode($data["review"]);
            $reviewObject->users_id = $data["users_id"];
            $reviewObject->movies_id = $data["movies_id"];

            return $reviewObject;
        }

        public function create(Review $review){
            $sql = "INSERT INTO reviews (rating, review, movies_id, users_id) VALUES (:rating, :review, :movies_id, :users_id)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":rating", $review->rating);
            $stmt->bindParam(":review", utf8_decode($review->review));
            $stmt->bindParam(":movies_id", $review->movies_id);
            $stmt->bindParam(":users_id", $review->users_id);

            $stmt->execute();

            //Review added successfully
            $this->message->setMessage("Review added successfully" , "success", $BASE_URL . "movie.php?id=" . $review->movies_id);
        }

        public function getMoviesReview($id){
            $sql = "SELECT * FROM reviews WHERE movies_id = :movies_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":movies_id", $id);
            $stmt->execute();

            $reviews = [];

            if($stmt->rowCount() > 0){
                $reviewsData = $stmt->fetchAll();

                $userDao = new UserDao($this->conn, $this->url);

                foreach ($reviewsData as $review) {
                    $reviewObject = $this->buildReview($review);

                    //Call user data
                    $user = $userDao->findById($reviewObject->users_id);

                    $reviewObject->user = $user;

                    $reviews[] = $reviewObject;
                }
            }
            return $reviews;
        }

        public function hasAlreadyReviewed($id, $userId){
            $sql = "SELECT * FROM reviews WHERE movies_id = :movies_id AND users_id = :users_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":movies_id", $id);
            $stmt->bindParam(":users_id", $userId);

            $stmt->execute();

            if($stmt->rowCount() > 0){
                return true;
            }
            else{
                return false;
            }
        }

        public function update(Review $review){
            $sql = "UPDATE reviews SET rating = :rating, review = :review WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":rating", $review->rating);
            $stmt->bindParam(":review", utf8_decode($review->review));
            $stmt->bindParam(":id", $review->id);

            $stmt->execute();

            $this->message->setMessage("Review updated successfully", "success", "movie.php?id=" . $review->movies_id);
        }

        public function getRatings($id){
            $sql = "SELECT * FROM reviews WHERE movies_id = :movies_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":movies_id", $id);

            $stmt->execute();

            if($stmt->rowCount() > 0){
                $rating = 0;

                $reviews = $stmt->fetchAll();

                foreach($reviews as $review){
                    $rating += $review["rating"];
                }

                $rating = $rating / count($reviews);
            }
            else{
                $rating = "No review yet";
            }

            return $rating;
        }

        public function findByUsersId($users_id, $movies_id){
            if($users_id != ""){

                $sql = "SELECT * FROM reviews WHERE users_id = :users_id and movies_id = :movies_id";

                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":users_id", $users_id);
                $stmt->bindParam(":movies_id", $movies_id);
                $stmt->execute();

                $reviews = [];

                if($stmt->rowCount() > 0){
                    $reviewsData = $stmt->fetch();

                    $userDao = new UserDao($this->conn, $this->url);

                    $reviewObject = $this->buildReview($reviewsData);
                    //Call user data
                    $user = $userDao->findById($reviewObject->users_id);

                    $reviewObject->user = $user;

                    $reviews = $reviewObject;
                }
                return $reviews;
            }
            else{
                return false;
            }
        }

        public function destroy(Review $review){
            $query1 = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($query1);
            $stmt->execute();

            $sql = "DELETE FROM reviews WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $review->id);
            $stmt->execute();

            $query2 = "SET FOREIGN_KEY_CHECKS=1";
            $stmt = $this->conn->prepare($query2);
            $stmt->execute();

            $this->message->setMessage("Review deleted successfully", "success", "movie.php?id=" . $review->movies_id);
        }
    }
?>