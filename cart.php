<?php
include 'header.php';

// if ($_POST) {
// }

$cart = new Cart;
$c = $cart->getCart($_SESSION['user_id']);
?>
<div class="cart-container py-5 px-5">
    <div class="row">
        <div class="col-lg-8 mb-5 mb-xl-0">
            <form class="cart-form" action="#">
                <div class="row">
                    <div class="col-12">
                        <div class="table-content table-responsive">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th class="text-left">Photo</th>
                                        <th class="text-left">Product</th>
                                        <th>Size</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $total = 0;
                                    foreach ($c as $k => $v) {
                                        $subtotal = $v['product_price'] * $v['cart_product_quantity'];
                                        $total += $subtotal;
                                    ?>
                                    <tr id="product_<?php echo $v['product_id'] . '_' . $v['cart_product_size']; ?>">
                                        <td class="product-remove text-center">
                                            <a href="javascript:"
                                                onclick="deleteCart(<?php echo $_SESSION['user_id'] . ',' . $v['product_id'] . ',\'' . $v['cart_product_size'] . '\''; ?>)">
                                                <i class="fa-solid fa-xmark"></i>
                                            </a>

                                        </td>
                                        <td class="product-thumbnail text-left">
                                            <img src="<?php echo $v['product_img']; ?>" width="100%" />
                                        </td>
                                        <td class="product-name text-left"
                                            style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                                            <a target="_blank"
                                                href="product-details.php?product_id=<?php echo $v['product_id']; ?>"><?php echo $v['product_name']; ?></a>
                                        </td>
                                        <td><?php echo $v['cart_product_size']; ?></td>
                                        <td class="product-price product_price"
                                            id="product_price_<?php echo $v['product_id'] . '_' . $v['cart_product_size']; ?>"
                                            data-price="<?php echo $v['product_price']; ?>">
                                            <?php echo formatPrice($v['product_price']); ?><span>đ</span>
                                        </td>
                                        <td class="product-quantity">
                                            <input type="number" class="quantity-input" name="qty" style="width: 100px;"
                                                id="product_quantity_<?php echo $v['product_id'] . '_' . $v['cart_product_size']; ?>"
                                                value="<?php echo $v['cart_product_quantity']; ?>" min="1"
                                                onchange="updateCart(<?php echo $_SESSION['user_id'] . $v['product_id'] . ', \'' . $v['cart_product_size'] . '\''; ?>, this.value)" />
                                        </td>
                                        <td class="product-total-price">
                                            <strong
                                                id="product_subtotal_<?php echo $v['product_id'] . '_' . $v['cart_product_size']; ?>"><?php echo formatPrice($subtotal); ?><span>đ</span></strong>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- <div class="col-sm-6 col-xl-7">
                        <div class="coupon border-bottom">
                            <input type="text" id="coupon" name="coupon" class="cart-form__input" placeholder="Mã giảm giá">
                            <button type="submit" class="cart-form__btn ml-auto">Áp dụng</button>
                        </div>
                    </div> -->
                    <!-- <div class=" col-sm-6 col-xl-5 ml-auto text-md-right text-sm-left py-4">
                        <button type="submit" class="cart-form__btn" name="clear" value="clear">Clear Cart</button>
                        <button type="submit" class="cart-form__btn" name="update" value="update">Update Cart</button>
                    </div> -->
                </div>
            </form>
        </div>
        <div class="col-lg-4">
            <div class="cart-collaterals">
                <div class="cart-totals">
                    <h5 class="mb-4">Cart totals</h5>
                    <div class="table-content table-responsive">
                        <table class="table order-table">
                            <tbody>
                                <!-- <tr>
                                    <th>Tổng tiền sản phẩm</th>
                                    <td><?php //echo formatPrice($total); 
                                        ?><span>đ</span></td>
                                </tr> -->
                                <!-- <tr>
                                    <th>Giảm giá</th>
                                    <td>$20.00</td>
                                </tr>
                                <tr>
                                    <th>Phí vận chuyển</th>
                                    <td>6.00<span>đ</span></td>
                                </tr> -->
                                <tr class="order-total border-top">
                                    <th>Tổng tiền</th>
                                    <td id="cart_subtotal"><?php echo formatPrice($total); ?><span>đ</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <a href="checkout.php" class="btn btn-checkout py-2" type="submit">Proceed To Checkout</a>
            </div>
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>