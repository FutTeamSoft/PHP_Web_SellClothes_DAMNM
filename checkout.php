<?php
include 'header.php';
$users = new User();
$user = $users->getUser($_SESSION['user_id']);
$cart = new Cart;
$c = $cart->getCart($_SESSION['user_id']);

if ($_POST['submit']) {
    $invoices = new Invoice;
    if ($invoices->postInvoice($_SESSION['user_id'], getPOST('user_full_name'), getPOST('billing_phone'), getPOST('billing_email'), getPOST('billing_address'))) {
        echo '<script>alert("Đặt hàng thành công!");location.replace("./");</script>';
    } else echo '<script>alert("Đặt hàng thất bại!");</script>';
}
?>
<div class="container">
    <form method="POST" action="">
        <div class="row my-lg-5 my-md-4 my-3">
            <!-- Checkout Area Start -->
            <div class="col-lg-6 col-xl-5 mt-4">
                <div class=" checkout-title mb-5">
                    <h2>Billing Details</h2>
                </div>
                <div class="checkout-form">
                    <!--Full name-->
                    <div class="row mb-4">
                        <div class="form__group col-12">
                            <label for="user_full_name">Tên khách hàng<span class="required">*</span></label>
                            <input disabled type="text" name="user_full_name" id="user_full_name"
                                value="<?php echo $user['user_full_name']; ?>" required />
                        </div>
                    </div>

                    <!--Phone-->
                    <div class="row mb-4">
                        <div class="form__group col-12">
                            <label for="billing_phone">Số điện thoại <span class="required">*</span></label>
                            <input disabled type="text" name="billing_phone" id="billing_phone"
                                value="<?php echo $user['user_phone_number']; ?>" required />
                        </div>
                    </div>
                    <!--mail-->
                    <div class="row mb-4">
                        <div class="form__group col-12">
                            <label for="billing_email">Email <span class="required">*</span></label>
                            <input disabled type="email" name="billing_email" id="billing_email"
                                value="<?php echo $user['user_email']; ?>" required />
                        </div>
                    </div>
                    <!--apartment number-->
                    <div class="row mb-4">
                        <div class="form__group col-12">
                            <label for="billing_address">Địa chỉ<span class="required">*</span></label>
                            <input disabled type="text" name="billing_address" id="billing_address"
                                value="<?php echo $user['user_address']; ?>" required />
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-6 offset-xl-1 col-lg-6 mt-4">
                <div class="order-details">
                    <div class="checkout-title mb-5">
                        <h2>Your Order</h2>
                    </div>
                    <div class="table-content table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Size</th>
                                    <th>Giá</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                foreach ($c as $k => $v) {
                                    $subtotal = $v['product_price'] * $v['cart_product_quantity'];
                                    $total += $subtotal;
                                ?>
                                <tr>
                                    <td><?php echo $v['product_name']; ?><strong><span
                                                class="multiply">&#10005;</span><?php echo $v['cart_product_quantity']; ?></strong>
                                    </td>
                                    <td><?php echo $v['cart_product_size']; ?></td>
                                    <td><?php echo formatPrice($v['product_price']); ?><span>đ</span></td>
                                    <td><?php echo formatPrice($subtotal); ?><span>đ</span></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <!-- <tr class="cart-subtotal">
                                <th>Tổng tiền</th>
                                <td></td>
                                <td>56.00<span>đ</span></td>
                            </tr> -->
                                <!-- <tr class="shipping">
                                <th>Vận chuyển</th>
                                <td></td>
                                <td>
                                    20.00<span>đ</span>

                                </td>
                            </tr> -->
                                <tr class="order-total">
                                    <th>Tổng đơn</th>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo formatPrice($total); ?><span>đ</span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="checkout-payment">

                        <div class="payment-group mt-2">
                            <p class="mb-2">
                                Bạn sẽ thanh toán khi nhận được hàng.
                            </p>
                            <button type="submit" name="submit" value="submit" class="btn btn-oder py-2">Place
                                Order</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Checkout Area End -->
        </div>
    </form>
</div>
<?php
include 'footer.php';
?>