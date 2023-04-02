<?php
include 'header.php';

$products = new Products();
if (isset($_POST['submit'])) {
    $product_id = is_int($_POST['product_id']) ? $_POST['product_id'] : '';
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_introduce = $_POST['product_introduce'];
    $product_detail = $_POST['product_detail'];
    $product_price = $_POST['product_price'];
    $product_img = $_POST['product_img'];
    $product_quantity = $_POST['product_quantity'];
    $product_location = $_POST['product_location'];
    $product_material = $_POST['product_material'];
    $product_type_id = $_POST['product_type_id'];
    $product_size = $_POST['product_size'];
    if ($_GET['act'] == 'add') {
        $res =    $products->postProduct($product_name, $product_introduce, $product_detail, $product_price, $product_img, $product_quantity, $product_location, $product_material, $product_type_id, $product_size);
        if ($res) {
            echo '<script>alert("Thêm thành công!");</script>';
            $product_id = $product_name = $product_introduce = $product_detail = $product_price = $product_img = $product_quantity = $product_location = $product_material = $product_type_id = $product_size = '';
        } else echo '<script>alert("Thêm thất bại!");</script>';
    } else if ($_GET['act'] == 'edit') {
        $res =    $products->updateProduct($_GET['product_id'], $product_name, $product_introduce, $product_detail, $product_price, $product_img, $product_quantity, $product_location, $product_material, $product_type_id, $product_size);
        if ($res) echo '<script>alert("Chỉnh sửa thành công!");</script>';
        else echo '<script>alert("Chỉnh sửa thất bại!");</script>';
    }
} else {
    if ($_GET['act'] == 'edit') {
        $product = $products->getProductById($_GET['product_id']);
        if ($product != false) {
            $product_id = $product['product_id'];
            $product_name = $product['product_name'];
            $product_introduce = $product['product_introduce'];
            $product_detail = $product['product_detail'];
            $product_price = $product['product_price'];
            $product_img = $product['product_img'];
            $product_quantity = $product['product_quantity'];
            $product_location = $product['product_location'];
            $product_material = $product['product_material'];
            $product_type_id = $product['product_type_id'];
            $product_size = $product['product_size'];
        }
    } else {
        $product_id = $product_name = $product_introduce = $product_detail = $product_price = $product_img = $product_quantity = $product_location = $product_material = $product_type_id = $product_size = '';
        $product_sizes = array();
    }
}
?>
<div class="container-fluid px-4">
    <h1 class="my-4">Thông tin sản phẩm</h1>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user"></i>
            Chi tiết sản phẩm
        </div>
        <form method="post" action="">
            <div class="card-body">
                <div class="table-Edit table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <td><input type="text" name="product_name" value="<?php echo $product_name; ?>" required /></td>
                            </tr>
                            <tr>
                                <th>Giới thiệu</th>
                                <td><input type="text" name="product_introduce" value="<?php echo $product_introduce; ?>" required /></td>
                            </tr>
                            <tr>
                                <th>Mô tả</th>
                                <td><textarea style="width: 100%;" name="product_detail" rows="8"><?php echo $product_detail; ?></textarea></td>
                            </tr>
                            <tr>
                                <th>Giá</th>
                                <td><input type="number" name="product_price" value="<?php echo $product_price; ?>" required /></td>
                            </tr>
                            <tr>
                                <th>Hình</th>
                                <td><input type="text" name="product_img" value="<?php echo $product_img; ?>" required /></td>
                            </tr>
                            <tr>
                                <th>Số lượng</th>
                                <td><input type="number" name="product_quantity" value="<?php echo $product_quantity; ?>" required /></td>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <td><input type="text" name="product_location" value="<?php echo $product_location; ?>" required /></td>
                            </tr>
                            <tr>
                                <th>Chất liệu</th>
                                <td><input type="text" name="product_material" value="<?php echo $product_material; ?>" required /></td>
                            </tr>
                            <tr>
                                <th>Loại</th>
                                <td>
                                    <select class="form-control" id="product_type_id" name="product_type_id">
                                        <?php
                                        $productTypes = new ProductTypes();
                                        foreach ($productTypes->getProductTypes() as $k => $v) {
                                            echo '<option value="' . $v['product_type_id'] . '"' . ($product_type_id == $v['product_type_id'] ? ' selected' : '') . '>' . $v['product_type_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Kích thước</th>
                                <td><input type="text" name="product_size" value="<?php echo $product_size; ?>" required /></td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
            <input type="submit" class="mybtn btn btn-outline-success" value="<?php echo getGET('act') == 'edit' ? 'Sửa' : 'Thêm'; ?>" name="submit" />
            <!--nếu chọn Edit thì value = chỉnh sửa-->
        </form>
    </div>
</div>
<?php
include 'footer.php';
