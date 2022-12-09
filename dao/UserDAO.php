<?php
    require_once("models/User.php");
    require_once("models/Message.php");

    class UserDAO implements UserDAOInterface{
        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url){
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildUser($data){
            $user = new User();

            $user->id = $data['id'];
            $user->name = utf8_encode($data['name']);
            $user->lastname = utf8_encode($data['lastname']);
            $user->email = $data['email'];
            $user->password = $data['password'];
            $user->image = $data['image'];
            $user->bio = utf8_encode($data['bio']);
            $user->token = $data['token'];

            return $user;
        }

        public function create(User $user, $authUser = false){
            $sql = "INSERT INTO users (name, lastname, email, password, token) VALUES (:name, :lastname, :email, :password, :token)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":name", utf8_decode($user->name));
            $stmt->bindParam(":lastname", utf8_decode($user->lastname));
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":token", $user->token);

            $stmt->execute();

            //Verify if user is authenticated
            if($authUser){
                $this->setTokenToSession($user->token);
            }
        }

        public function update(User $user, $redirect = true){
            $sql = "UPDATE users SET name = :name, lastname = :lastname, email = :email, password = :password, image = :image, bio = :bio, token = :token WHERE id = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":name", utf8_decode($user->name));
            $stmt->bindParam(":lastname", utf8_decode($user->lastname));
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":image", $user->image);
            $stmt->bindParam(":bio", utf8_decode($user->bio));
            $stmt->bindParam(":token", $user->token);
            $stmt->bindParam(":id", $user->id);

            $stmt->execute();

            if($redirect){
                //Redirect to profile page
                $this->message->setMessage("Profile updated successfully", "success", "editprofile.php");
            }
        }

        public function verifyToken($protected = false){
            if(!empty($_SESSION['token'])){
                //Get token from session
                $token = $_SESSION['token'];
        
                $user = $this->findByToken($token);
        
                if($user){
                    return $user;
                }
                else if($protected){
                    //Redirect to index page
                    $this->message->setMessage("You are not logged in", "error", "index.php");
                }
            }
            else if($protected){
                //Redirect to index page
                $this->message->setMessage("You are not logged in", "error", "index.php");
            }
        }

        public function setTokenToSession($token, $redirect = true){
            //Save token in session
            $_SESSION['token'] = $token;

            //Redirect to user profile page
            if($redirect){
                $this->message->setMessage("You are logged in", "success", "editprofile.php");
            }
        }

        public function destroyToken(){
            //Destroy token in session
            $_SESSION['token'] = "";

            //Redirect and show success message
            $this->message->setMessage("You are logged out", "success", "index.php");
            
        }

        public function authenticateUser($email, $password){
            $user = $this->findByEmail($email);

            if($user){
                //Verify password
                if(password_verify($password, $user->password)){
                    //Generate and set token to session
                    $token = $user->generateToken();
                    $this->setTokenToSession($token, false);

                    //Update token in database
                    $user->token = $token;
                    $this->update($user, $redirect = false);

                    return true;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }

        public function findByToken($token){
            if($token != ""){

                $sql = "SELECT * FROM users WHERE token = :token";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":token", $token);
                $stmt->execute();

                if($stmt->rowCount() > 0){
                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);
                    
                    return $user;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }

        public function findByEmail($email){
            if($email != ""){

                $sql = "SELECT * FROM users WHERE email = :email";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":email", $email);
                $stmt->execute();

                if($stmt->rowCount() > 0){
                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);
                    
                    return $user;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }

        public function findById($id){
            if($id != ""){

                $sql = "SELECT * FROM users WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();

                if($stmt->rowCount() > 0){
                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);
                    
                    return $user;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }

        public function changePassword(User $user){
            $sql = "UPDATE users SET password = :password WHERE id = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":id", $user->id);
            
            $stmt->execute();

            //Redirect to profile page
            $this->message->setMessage("Password changed successfully", "success", "editprofile.php");
        }
    }
?>