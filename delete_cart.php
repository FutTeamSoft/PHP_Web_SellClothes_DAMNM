<?php
require_once "cart.php";

$cart = new Cart();
$user_id = $_SESSION['user_id'];
$product_id = $_GET['product_id'];
$cart_product_size = $_GET['cart_product_size'];
$success = $cart->deleteCart($user_id, $product_id, $cart_product_size);
if ($success) {
    echo "Sản phẩm đã được xóa khỏi giỏ hàng.";
} else {
    echo "Không thể xóa sản phẩm khỏi giỏ hàng.";
}
