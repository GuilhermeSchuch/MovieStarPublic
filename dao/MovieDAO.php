<?php
    require_once("models/Movie.php");
    require_once("models/Message.php");
    require_once("dao/ReviewDAO.php");

    class MovieDAO implements MovieDAOInterface{
        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url){
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildMovie($data){
            $movie = new Movie();

            $movie->id = $data['id'];
            $movie->title = utf8_encode($data['title']);
            $movie->description = utf8_encode($data['description']);
            $movie->image = $data['image'];
            $movie->trailer = $data['trailer'];
            $movie->category = $data['category'];
            $movie->length = $data['length'];
            $movie->users_id = $data['users_id'];

            //Get movie ratings
            $reviewDao = new ReviewDao($this->conn, $this->url);

            $rating = $reviewDao->getRatings($movie->id);

            if(gettype($rating) === "string"){
                $movie->rating = $rating;
            }
            else{
                $movie->rating = round($rating, 1);
            }

            return $movie;
        }

        public function findAll(){

        }

        public function getUserIdByMovieId($id){
            $query = "SELECT users.id FROM users JOIN movies ON users.id = movies.users_id WHERE movies.id = :movies_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':movies_id', $id);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $userId = $stmt->fetch();
            }

            return $userId;
        
        }

        public function getLatestMovies(){
            //Get screen resolution to print the correct movie amount
            if (!isset($_COOKIE['resolucao'])) {
                ?>
                <script language='javascript'>
                document.cookie = "resolucao="+screen.width+"x"+screen.height;
                self.location.reload();
                </script>
                <?php }else
                
                $resolucao = list($width,$height)=explode("x",$_COOKIE['resolucao']);

            if($width >= 1900){
                $query = "SELECT * FROM movies ORDER BY id DESC LIMIT 6";
            }
            else{
                $query = "SELECT * FROM movies ORDER BY id DESC LIMIT 5";
            }

            $movies = [];
            $stmt = $this->conn->query($query);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $moviesArray = $stmt->fetchAll();

                foreach($moviesArray as $movie){
                    $movies[] = $this->buildMovie($movie);
                }
            }

            return $movies;
        }

        public function getAllLatestMovies(){
            $movies = [];
            
            $query = "SELECT * FROM movies ORDER BY id DESC";

            $stmt = $this->conn->query($query);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $moviesArray = $stmt->fetchAll();

                foreach($moviesArray as $movie){
                    $movies[] = $this->buildMovie($movie);
                }
            }

            return $movies;
        }

        public function getMoviesByCategory($category){
            //Get screen resolution to print the correct movie amount
            if (!isset($_COOKIE['resolucao'])) {
                ?>
                <script language='javascript'>
                document.cookie = "resolucao="+screen.width+"x"+screen.height;
                self.location.reload();
                </script>
                <?php }else
                
                $resolucao = list($width,$height)=explode("x",$_COOKIE['resolucao']);

            if($width >= 1900){
                $query = "SELECT m.id, m.title, m.description, m.image, m.trailer, m.length, m.users_id, m.category,
            avg(r.rating) as rating FROM movies m LEFT JOIN reviews r ON m.id = r.movies_id WHERE category = :category GROUP by(m.title) order by m.category, rating DESC LIMIT 6;";
            }
            else{
                $query = "SELECT m.id, m.title, m.description, m.image, m.trailer, m.length, m.users_id, m.category,
            avg(r.rating) as rating FROM movies m LEFT JOIN reviews r ON m.id = r.movies_id WHERE category = :category GROUP by(m.title) order by m.category, rating DESC LIMIT 5;";
            }

            $movies = [];

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':category', $category);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $moviesArray = $stmt->fetchAll();

                foreach($moviesArray as $movie){
                    $movies[] = $this->buildMovie($movie);
                }
            }

            return $movies;
        }

        public function getAllMoviesByCategory($category){
            $query = "SELECT m.id, m.title, m.description, m.image, m.trailer, m.length, m.users_id, m.category,
            avg(r.rating) as rating FROM movies m LEFT JOIN reviews r ON m.id = r.movies_id WHERE category = :category GROUP by(m.title) order by m.category, rating DESC";

            $movies = [];

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':category', $category);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $moviesArray = $stmt->fetchAll();

                foreach($moviesArray as $movie){
                    $movies[] = $this->buildMovie($movie);
                }
            }

            return $movies;
        }

        public function hasAlreadyAdded($id){
            $sql = "SELECT * FROM movies WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $id);

            $stmt->execute();

            if($stmt->rowCount() > 0){
                return true;
            }
            else{
                return false;
            }
        }

        public function getMovieByUserId($id){
            $movies = [];
        
            $query = "SELECT m.id, m.title, m.description, m.image, m.trailer, m.length, m.users_id, m.category,
            avg(r.rating) as rating FROM movies m LEFT JOIN reviews r ON m.id = r.movies_id WHERE m.users_id = :users_id GROUP by(m.title) order by rating DESC;";
            //$query = "SELECT * FROM movies WHERE users_id = :users_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':users_id', $id);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $moviesArray = $stmt->fetchAll();

                foreach($moviesArray as $movie){
                    $movies[] = $this->buildMovie($movie);
                }
            }

            return $movies;
        }

        public function getUserNameByMovieId($id){
            $query = "SELECT users.name, users.lastname FROM users JOIN movies ON users.id = movies.users_id WHERE movies.id = :movies_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':movies_id', $id);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $user = $stmt->fetch();
            }

            return implode(" ", array_unique($user));
        }

        public function findById($id){
            $movie = [];

            $query = "SELECT * FROM movies WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $movieData = $stmt->fetch();
                $movie = $this->buildMovie($movieData);

                return $movie;
            }
            else{
                return false;
            }
        }

        public function findByTitle($title){
            $movies = [];

            $query = "SELECT * FROM movies WHERE title LIKE :title";

            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':title', '%'.$title.'%');
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $moviesArray = $stmt->fetchAll();

                foreach($moviesArray as $movie){
                    $movies[] = $this->buildMovie($movie);
                }
            }

            return $movies;
        }

        public function findByTitleCreate($title){
            $movies = [];

            $query = "SELECT * FROM movies WHERE title = :title";

            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':title', $title);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $moviesArray = $stmt->fetchAll();

                foreach($moviesArray as $movie){
                    $movies[] = $this->buildMovie($movie);
                }
            }

            return $movies;
        }

        public function create(Movie $movie){
            $sql = "INSERT INTO movies (title, description, image, trailer, category, length, users_id) VALUES (:title, :description, :image, :trailer, :category, :length, :users_id)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":title", utf8_decode($movie->title));
            $stmt->bindParam(":description", utf8_decode($movie->description));
            $stmt->bindParam(":image", $movie->image);
            $stmt->bindParam(":trailer", $movie->trailer);
            $stmt->bindParam(":category", $movie->category);
            $stmt->bindParam(":length", $movie->length);
            $stmt->bindParam(":users_id", $movie->users_id);

            $stmt->execute();

            //Movie added successfully
            $this->message->setMessage("Movie added successfully", "success", "index.php");
        }

        public function update(Movie $movie){
            $sql = "UPDATE movies SET title = :title, description = :description, image = :image, category = :category, trailer = :trailer, length = :length WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":title", utf8_decode($movie->title));
            $stmt->bindParam(":description", utf8_decode($movie->description));
            $stmt->bindParam(":image", $movie->image);
            $stmt->bindParam(":category", $movie->category);
            $stmt->bindParam(":trailer", $movie->trailer);
            $stmt->bindParam(":length", $movie->length);
            $stmt->bindParam(":id", $movie->id);

            $stmt->execute();

            $this->message->setMessage("Movie updated successfully", "success", "dashboard.php");
        }

        public function destroy($id){
            $query1 = "SET FOREIGN_KEY_CHECKS=0";
            $stmt = $this->conn->prepare($query1);
            $stmt->execute();

            $sql = "DELETE FROM movies WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            $query2 = "SET FOREIGN_KEY_CHECKS=1";
            $stmt = $this->conn->prepare($query2);
            $stmt->execute();

            $this->message->setMessage("Movie deleted successfully", "success", "dashboard.php");
        }
    }
?>