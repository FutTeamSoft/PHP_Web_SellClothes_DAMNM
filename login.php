<?php
include 'header.php';

if ($_POST['submit']) {
    $user = new User;
    $u = $user->login(getPOST('email'), getPOST('password'));
    if ($u != false) {
        $user->startSession($u);
        echo '<script>alert("Đăng nhập thành công! Đang chuyển hướng đến trang chủ...");location.replace("./");</script>';
    } else {
        echo 'Tài khoản không đúng!';
    }
}
?>
<div id="authenForm">
    <div class="container-authenForm shadow">
        <div class="cover">
            <div class="front">
                <img src="assets/img/authenbackgroundImage.jpg" alt="" />
            </div>
        </div>
        <form method="post" action="">
            <div class="form-content">
                <div class="login-form">
                    <div class="title">Login</div>
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="email" placeholder="Enter your email" name="email" required />
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" placeholder="Enter your password" name="password" required />
                        </div>
                        <div class="text"><a href="#">Forgot password?</a></div>
                        <div class="button input-box">
                            <input type="submit" name="submit" value="Sumbit" />
                        </div>
                        <div class="text sign-up-text">
                            Don't have an account? <a href="register.php">Signup now</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
include 'footer.php';
?>