<?php
include 'header.php';

if ($_POST['submit']) {
    $carts = new Cart;
    $carts->postCart($_SESSION['user_id'], getPOST('product_id'), getPOST('size'), getPOST('quantity'));
}

$product = new Products();
$p = $product->getProductById(getGET('product_id'));
if ($p == false) {
?>
báo lỗi không thấy.
<?php
} else {
?>
<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item ml-5"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="products.php">Product</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $p['product_name']; ?></li>
        </ol>
    </nav>

    <div class="product-details">
        <form method="post" action="">
            <div class="row">
                <div class="col-md-2 col-lg-1 col-4">
                    <ul class="list__img-small">
                        <li>
                            <img src="<?php echo $p['product_img']; ?>" />
                        </li>
                    </ul>
                </div>
                <div class="col-md-5 col-lg-4 mx-auto">
                    <div class="imgBox">
                        <img src="<?php echo $p['product_img']; ?>" />
                    </div>
                </div>
                <div class="col-md-4 mx-auto">
                    <h1 class="name-product" style="word-wrap: break-word; white-space:normal"
                        title="<?php echo $p['product_name']; ?>"><?php echo $p['product_name']; ?></h1>
                    <h2 class="price-product"><?php echo formatPrice($p['product_price']); ?> <span>&nbsp;VND</span>
                    </h2>
                    <hr class="light" />
                    <h5>Describe</h5>
                    <p><?php echo str_replace("\n", '<br/>', $p['product_detail']); ?></p>

                    <h5>Size</h5>
                    <div class="btn-group mr-2 btn-group-size" role="group" aria-label="Basic example">
                        <select name="size">
                            <?php
                                foreach (explode('|', $p['product_size']) as $k => $v) {
                                    // echo '<button type="button" class="btn btn-outline-secondary ">' . $v . '</button>';
                                    echo '<option value="' . $v . '">' . $v . '</option>';
                                }
                                ?></select>
                    </div>
                    <h5>quantity</h5>
                    <div class="btn-quantity shadow-sm">
                        <span class="minus">-</span>
                        <span class="num">01</span>
                        <span class="plus">+</span>
                    </div>
                    <input type="hidden" value="<?php echo $p['product_id'] ?>" name="product_id" />
                    <input id="num" type="hidden" value="1" name="quantity" />
                    <?php
                        if ($_SESSION['user_id']) { ?>
                    <button class="btn btn-warning btn-addtocart shadow my-4" type="submit" name="submit"
                        value="submit">Add to cart</button>
                    <?php
                        } else {
                        ?>
                    <a href="login.php">Vui lòng đăng nhập để mua vật phẩm!</a>
                    <?php
                        }
                        ?>


                </div>
            </div>
        </form>
    </div>
</div>
<?php
}
include 'footer.php';
?>