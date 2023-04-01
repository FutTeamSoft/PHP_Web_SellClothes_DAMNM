<?php
include 'header.php';

if ($_POST['submit']) {
    $user = new User;
    if (getPOST('pass') == getPOST('repass'))
        if ($user->register(getPOST('fullname'), getPOST('email'),getPOST('address'),getPOST('phone'), getPOST('pass')))
            echo '<script>alert("Đăng ký thành công! Vui lòng đăng nhập!");location.replace("login.php");</script>';
        else echo '<script>alert("Đăng ký thất bại!");</script>';
    else echo '<script>alert("Mật khẩu nhập lại không trùng khớp!! Vui lòng thử lại!");</script>';
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
                <div class="signup-form">
                    <div class="title">Signup</div>
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-user"></i>
                            <input type="text" placeholder="Enter your name" name="fullname" required />
                        </div>
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="email" placeholder="Enter your email" name="email" required />
                        </div>
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="text" placeholder="Enter your address" name="address" required />
                        </div>
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="tel" placeholder="Enter your phone" name="phone" required />
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" placeholder="Enter your password" name="pass" required />
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" placeholder="Confirm password" name="repass" required />
                        </div>
                        <div class="button input-box">
                            <input type="submit" value="Sumbit" name="submit" />
                        </div>
                        <div class="text login-text">
                            Already have an account? <a href="login.php">Login now</a>
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