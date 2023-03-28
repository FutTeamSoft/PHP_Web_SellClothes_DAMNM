<?php
include 'header.php';
?>
<div class="landing">
    <div class="home-wrap">
        <div class="home-inner"></div>
        <div class="caption text-left">
            <h1>Welcome to FTeam</h1>
            <p>Fashion is like the breath of life every day and it always changes with the flow of events. You can even
                see a revolutionary approach in clothing. You can see and feel everything with fashion.</p>
            <button class="btn-lg btn-shopnow shadow rounded"><a href="products.php">Shop now</a></button>
        </div>
    </div>
</div>
<div>
    <div class="jumbotron">
        <div class="narrow text-center">
            <div class="col-12">
                <h3 class="heading">New Product</h3>
                <div class="heading-underline"></div>
            </div>

            <div class="row text-center">
                <?php
                $product = new Products();
                foreach ($product->getProducts(1, 1, 4) as $k => $v) { ?>
                <div class="col-md-3">
                    <a class="card" href="product-details.php?product_id=<?php echo $v['product_id']; ?>">
                        <img src="<?php echo $v['product_img'] ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;"
                                title="<?php echo $v['product_name']; ?>" class="name-product card-title">
                                <?php echo $v['product_name'] ?></p>
                            <p class="price-product card-text"><?php echo formatPrice($v['product_price']) ?><span
                                    class="currency-symbol">&#160;VND</span></p>
                        </div>
                    </a>
                </div>
                <?php
                }
                ?>

            </div>
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>