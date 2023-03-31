<?php
include 'header.php';

$products = new Product;
?>
<div class="container-fluid px-4">
    <h1 class="my-4">Quản lý sản phẩm</h1>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table "></i>
            Sản phẩm
        </div>
        <div class="card-body">
            <table id="datatablesProduct" class="table-responsive">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Hình</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Từ</th>
                        <th>Chất liệu</th>
                        <th>Loại sản phẩm</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products->getProducts(1, 0, 0) as $k => $v) { ?>
                        <tr>
                            <td><?php echo $v['product_name']; ?></td>
                            <td><img class="img-thumbnail" style="width:75px" src="<?php echo $v['product_img']; ?>" /></td>
                            <td><?php echo formatPrice($v['product_price']); ?><span>đ</span></td>
                            <td><?php echo $v['product_quantity']; ?></td>
                            <td><?php echo $v['product_location']; ?></td>
                            <td><?php echo $v['product_material']; ?></td>
                            <td><?php echo $v['product_type_name']; ?></td>
                            <td><a href="product.php?act=edit&product_id=<?php echo $v['product_id']; ?>" class="btn btn-info px-3 mb-1">Edit</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
include 'footer.php';
