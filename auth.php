<?php
    require_once("templates/header.php");
?>

    <div id="main-container" class="container-fluid">
        <div class="col-md-12">
            <div class="row" id="auth-row">
                <div class="col-md-4" id="login-container">
                    <h2>Sign in</h2>

                    <form action="<?= $BASE_URL ?>auth_process.php" method="post">
                        <input type="hidden" name="type" value="login">

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" id="email" class="form-control emailLogin" placeholder="Email" onclick="addCapsLockWarning('.emailLogin', '#capsLockEmailLogin')">
                            <p class="text-description" id="capsLockEmailLogin" style="display:none">Caps Lock On</p>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control passLogin" placeholder="Password" onclick="addCapsLockWarning('.passLogin', '#capsLockPassLogin')">
                            <p class="text-description" id="capsLockPassLogin" style="display:none">Caps Lock On</p>
                        </div>

                        <input type="submit" value="Sign in" class="btn card-btn">
                    </form>
                </div>

                <div class="col-md-4" id="register-container">
                    <h2>Sign up</h2>

                    <form action="<?= $BASE_URL ?>auth_process.php" method="post">
                        <input type="hidden" name="type" value="register">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" onclick="addCapsLockWarning('#name', '#capsLockName')">
                            <p class="text-description" id="capsLockName" style="display:none">Caps Lock On</p>
                        </div>

                        <div class="form-group">
                            <label for="lastname">Lastname</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Lastname" onclick="addCapsLockWarning('#lastname', '#capsLockLastname')">
                            <p class="text-description" id="capsLockLastname" style="display:none">Caps Lock On</p>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" id="email" class="form-control emailRegister" placeholder="Email" onclick="addCapsLockWarning('.emailRegister', '#capsLockEmailRegister')">
                            <p class="text-description" id="capsLockEmailRegister" style="display:none">Caps Lock On</p>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control passRegister" placeholder="Password" onclick="addCapsLockWarning('.passRegister', '#capsLockPassRegister')">
                            <p class="text-description" id="capsLockPassRegister" style="display:none">Caps Lock On</p>
                            <p class="text-description">Don't use your real email password</p>
                        </div>
                        
                        <div class="form-group">
                            <label for="confirmpassword">Confirm password</label>
                            <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Confirm password" onclick="addCapsLockWarning('#confirmpassword', '#capsLockConfirmPassword')">
                            <p class="text-description" id="capsLockConfirmPassword" style="display:none">Caps Lock On</p>
                        </div>
                        
                        <input type="submit" value="Sign up" class="btn card-btn">
                </div>
            </div>
        </div>
        <div id="space"></div>  
    </div>

<style>
    @media((min-height: 1000px)) {
        #space{
        min-height: 50vh;
        }
    }
</style>
<?php
    require_once("templates/footer.php");
?>