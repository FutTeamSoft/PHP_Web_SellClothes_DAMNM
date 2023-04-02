<?php
include 'header.php';

if (isset($_POST['product_id']) && isset($_POST['cart_product_size']) && isset($_POST['cart_product_quantity'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $cart_product_size = $_POST['cart_product_size'];
    $cart_product_quantity = $_POST['cart_product_quantity'];
    $cart = new Cart;
    $cart->updateCart($user_id, $product_id, $cart_product_size, $cart_product_quantity);
}

include 'footer.php';
