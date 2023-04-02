<?php
include 'config/config.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FTeam Clothes</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/bootstrap-grid.css" rel="stylesheet" />
    <link href="assets/css/bootstrap-reboot.css" rel="stylesheet" />
    <link href="assets/css/Site.css" rel="stylesheet" />
    <script src="assets/js/modernizr-2.8.3.js"></script>
    <link href="assets/css/base.css" rel="stylesheet" />
    <link href="assets/css/main.css" rel="stylesheet" />
    <link href="assets/fonts/fontawesome-free-6.1.1-web/css/all.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&display=swap" rel="stylesheet">
</head>

<body>
    <!--Navigation-->
    <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top shadow-sm rounded">
        <a class="navbar-brand ml-5" href="index.php">FTeam</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-center" id="navbarResponsive">
            <ul class="navbar-nav ml-auto mr-5">
                <li class="nav-item">
                    <a class="nav-link" href="./">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="products.php">Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>

            </ul>
            <ul class="navbar-nav mr-5">
                <li class="nav-item">
                    <a class="nav-link search-icon" data-toggle="collapse" href="#searchBar" aria-expanded="false" aria-controls="searchBar"><i class="fa fa-search"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php"><i class="fa fa-bag-shopping"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#menuAccount" aria-expanded="false" aria-controls="menuAccount"><i class="fa fa-user"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav mr-5">
                <li class="nav-item">
                    <?php if (!$_SESSION['user_id']) echo '<a class="nav-link" href="login.php">Login</a>'; ?>
                </li>
            </ul>

        </div>
    </nav>
    <!--Thanh tiềm kiếm-->
    <div id="searchBar" class="collapse">
        <form action="products.php" class="search-bar mx-auto mb-2 mt-1">
            <input type="search" placeholder="search product" name="search" />
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <!--Hết Thanh tiềm kiếm-->

    <!--Nút scroll ont top-->
    <div id="progress">
        <span id="progress-value"><i class="fa-solid fa-arrow-up"></i></span>
    </div>
    <!--Hết nút scroll on top-->

    <!--Menu tài khoản khi đăng nhập-->
    <div class="collapse " id="menuAccount">
        <div class="py-2 px-5 text-right">
            <?php
            if ($_SESSION['user_id']) echo '<a href="#">Xin chào, ' . $_SESSION['user_full_name'] . '!</a><a href="my-account.php">Account</a><a href="invoices.php">History</a><a href="logout.php">Logout</a>';
            else echo '<a href="login.php">Vui lòng đăng nhập!</a>';
            ?>
        </div>
    </div>
    <!--Hết Menu tài khoản khi đăng nhập-->
    <!--End-Navigation-->
    <!--Body-->

    <script>
        function update_cart(product_id, cart_product_size) {
            var quantity_input = document.getElementById("product_quantity_" + product_id + "_" + cart_product_size);
            var quantity = parseInt(quantity_input.value);
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    location.reload(); // Tải lại trang để cập nhật giỏ hàng
                }
            }
            xhr.open("POST", "update-cart.php");
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("product_id=" + product_id + "&cart_product_size=" + cart_product_size + "&cart_product_quantity=" +
                quantity);
        }

        var update_buttons = document.querySelectorAll(".product-update-button");
        for (var i = 0; i < update_buttons.length; i++) {
            var button = update_buttons[i];
            button.addEventListener("click", function() {
                var product_id = this.getAttribute("data-product-id");
                var cart_product_size = this.getAttribute("data-cart-product-size");
                update_cart(product_id, cart_product_size);
            });
        }
    </script>
    <script>
        function del_cart(product_id, cart_product_size) {
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')) {
                // Gửi yêu cầu xóa sản phẩm tới file PHP
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("product_" + product_id + "_" + cart_product_size).remove();
                        location.reload(); // Tải lại trang để cập nhật giỏ hàng
                        alert("Xóa giỏ hàng thành công!");
                    }
                };
                xmlhttp.open("GET", "delete_cart.php?product_id=" + product_id + "&cart_product_size=" + cart_product_size,
                    true);
                xmlhttp.send();
            }
        }
    </script>