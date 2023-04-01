<?php
include 'header.php';

$invoices = new Invoice;
$inv = $invoices->getInvoiceDetails(getGET('invoice_id'));
?>
<div class="container-xl history-container py-5 px-5">
    <div class="table-content table-responsive">
        <h2 class="mb-5">Chi tiết đơn hàng: <span><?php echo $inv[0]['invoice_id']; ?></span></h2>
        <table class="table text-center">
            <thead class="border-bottom text-left">
                <tr>
                    <th>&nbsp;</th>
                    <th>Sản phẩm</th>
                    <th>Size</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
            <tbody class="text-left">
                <?php foreach ($inv as $k => $v) { ?>
                <tr>
                    <td class="product-thumbnail">
                        <img src="<?php echo $v['product_img']; ?>" />
                    </td>
                    <td class="product-name">
                        <a href=""><?php echo $v['product_name']; ?></a>
                    </td>
                    <td class="detail_product_size">
                        <?php echo $v['detail_product_size']; ?>
                    </td>

                    <td class="bill-total"><?php echo $v['detail_product_quantity']; ?></td>
                    <td class="product-quantity"><?php echo formatPrice($v['product_price']); ?><span> VNĐ</span>
                    </td>
                    <td class="product-total-price">
                        <?php echo formatPrice($v['detail_product_quantity'] * $v['product_price']); ?><span> VNĐ</span>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="invoices.php" class="btn btn-outline-dark mt-5">Quay lại lịch sử đơn hàng</a>
    </div>
</div>
<?php
include 'footer.php';