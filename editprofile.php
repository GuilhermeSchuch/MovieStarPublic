<?php
    require_once("templates/header.php");
    require_once("models/User.php");
    require_once("dao/UserDAO.php");

    $user = new User();

    $userDAO = new UserDAO($conn, $BASE_URL);
    $userData = $userDAO->verifyToken(true);

    $fullName = $userData->getFullName($userData);

    if($userData->image == ""){
        $userData->image = "user.png";
    }

    $validation = strpos($_SERVER["HTTP_USER_AGENT"], "Mobile");
?>

    <div id="main-container" class="container-fluid edit-profile-page">
        <div class="col-md-12">
            <form action="<?= $BASE_URL ?>user_process.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="type" value="update">

                <div class="row">
                    <div class="col-md-4">
                        <h1><?= $fullName ?></h1>
                        <p class="page-description">Change your data in the form below</p>

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $userData->name ?>" onclick="addCapsLockWarning('#name', '#capsLockName')">
                            <p class="text-description" id="capsLockName" style="display:none">Caps Lock On</p>
                        </div>

                        <div class="form-group">
                            <label for="lastname">Lastname:</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" value="<?= $userData->lastname ?>" onclick="addCapsLockWarning('#lastname', '#capsLockLastName')">
                            <p class="text-description" id="capsLockLastName" style="display:none">Caps Lock On</p>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" readonly class="form-control disabled" id="email" name="email" value="<?= $userData->email ?>">
                        </div>

                        <input type="submit" value="Change" class="btn card-btn">
                    </div>

                    <div class="col-md-4">
                        <div id="profile-image-container" 
                        style="background-image: url('<?= $BASE_URL?>img/users/<?= $userData->image ?>');">
                        </div>

                        <!-- <div class="form-group">
                            <label for="image">Image:</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div> -->
                        
                        <?php if($validation == True): ?>
                            <label>Upload an image or take a picture</label>
                        <?php else: ?>
                            <label>Image:</label>
                        <?php endif; ?>

                        <?php if($validation != True): ?>
                            <div class="upload" style=>
                                <button type="button" class="btn-warning">
                                    <i class="fa fa-upload"></i> Upload File
                                    <input type="file" id="image" name="image" class="input_upload">
                                </button>
                                <span class="file_text"></span>
                            </div>

                            <script>
                                let input = document.querySelector(".input_upload");
                                
                                input.addEventListener('change', (e) => {
                                    output = input.value;
                                    output = output.replace("C:\\fakepath\\", '');
                                    
                                    $span = document.querySelector(".file_text");
                                    $span.textContent = output;
                                });
                            </script>
                        <?php endif; ?>

                        <?php if($validation == True): ?>
                            <div class="upload" style="margin-top: 5px; margin-bottom: 5px">
                                <button type="button" class="btn-warning">
                                    <i class="fa-solid fa-camera"></i> Take a picture
                                    <input type="file" id="image" name="image" class="input_picture">
                                </button>
                                <span class="file_text"></span>
                            </div>

                            <script>
                                let input = document.querySelector(".input_picture");
                                
                                input.addEventListener('change', (e) => {
                                    output = input.value;
                                    output = output.replace("C:\\fakepath\\", '');
                                    
                                    $span = document.querySelector(".file_text");
                                    $span.textContent = output;
                                });
                            </script>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="bio">About you:</label>
                            <textarea class="form-control" id="bio" name="bio" rows="5"
                            placeholder="Tell who you are..." onclick="addCapsLockWarning('#bio', '#capsLockBio')"><?= $userData->bio ?></textarea>
                            <p class="text-description" id="capsLockBio" style="display:none">Caps Lock On</p>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row" id="change-password-container">
                <div class="col-md-4">
                    <h2>Change password:</h2>
                    <p class="page-description">
                        Type your new password and confirm to change it:
                    </p>

                    <form action="<?= $BASE_URL ?>user_process.php" method="post">
                        <input type="hidden" name="type" value="changepassword">
                        <input type="hidden" name="id" value="<?= $userData->id ?>">

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password"
                            placeholder="Type your password" onclick="addCapsLockWarning('#password', '#capsLockPassword')">
                            <p class="text-description" id="capsLockPassword" style="display:none">Caps Lock On</p>
                        </div>

                        <div class="form-group">
                            <label for="confirmpassword">Confirm password:</label>
                            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword"
                            placeholder="Confirm your password" onclick="addCapsLockWarning('#confirmpassword', '#capsLockConfirmPassword')">
                            <p class="text-description" id="capsLockConfirmPassword" style="display:none">Caps Lock On</p>
                        </div>

                        <input type="submit" value="Change password" class="btn card-btn">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        input{
            overflow-x: hidden;
        }
    </style>
<?php
    require_once("templates/footer.php");
?>