<?php
include '../config/config.php';

if (isset($_POST['submit'])) {
    $admin = new Admin();
    if ($admin->login($_POST['password'])) {
        $admin->startSession();
        header('Location: ./');
    }
}
?>
<html>

<head>
    <meta name="viewport" content="width=device-width" />
    <title>LogIn - FTeam</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/bootstrap-grid.css" rel="stylesheet" />
    <link href="../assets/css/bootstrap-reboot.css" rel="stylesheet" />
    <script src="../assets/js/modernizr-2.8.3.js"></script>
    <link href="../assets/css/base.css" rel="stylesheet" />
    <link href="../assets/css/elegant-icons.css" rel="stylesheet" />
    <link href="../assets/fonts/fontawesome-free-6.1.1-web/css/all.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="../assets/css/style-admin.css" rel="stylesheet" />
</head>

<body class="d-flex justify-content-center">

    <div>
        <label class="Login-label">FTEAM</label>
    </div>

    <div class="login-container shadow">
        <form method="post" action="">
            <div class="login-head">
                <p class="text-center">Login Admin</p>
            </div>
            <div class="login-body">
                <div class="row mb-4">
                    <div class="col-12 col-md-3">
                        <h6>Password</h6>
                    </div>
                    <div class="col-12 col-md-9">
                        <input class="login-input" placeholder="Nhập mật khẩu của bạn" type="password" name="password" />
                    </div>
                </div>
                <input type="submit" class=" btn btn-info login-btn" name="submit" value="Login" />
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="../assets/js/admin.js"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>