<?php
    Class Movie{
        public $id;
        public $title;
        public $description;
        public $image;
        public $trailer;
        public $category;
        public $length;
        public $user_id;

        public function imageGenerateName(){
            return bin2hex(random_bytes(60)) . ".jpg";
        }
    }

    interface MovieDAOInterface{
        public function buildMovie($data);
        public function findAll();
        public function getLatestMovies();
        public function getAllLatestMovies();
        public function getMoviesByCategory($category);
        public function getAllMoviesByCategory($category);
        public function getMovieByUserId($id);
        public function getUserNameByMovieId($id);
        public function getUserIdByMovieId($id);
        public function hasAlreadyAdded($id);
        public function findById($id);
        public function findByTitle($title);
        public function findByTitleCreate($title);
        public function create(Movie $movie);
        public function update(Movie $movie);
        public function destroy($id);
    }
?>