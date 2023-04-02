<?php
include 'header.php';

$invoices = new Invoice();
$inv = $invoices->getInvoice(getGET('invoice_id'));
$users = new User();
$u = $users->getUser($inv['user_id']);
if (getPOST('invoice_status_id')) {
    $invoices->updateStatus($inv['invoice_id'], getPOST('invoice_status_id'));
    $inv = $invoices->getInvoice(getGET('invoice_id'));
}
?>


<div class="container-fluid px-4 mt-5 row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h1>FTeam</h1>
                    <div>
                        <h2>Hóa đơn #<span><?php echo $inv['invoice_id']; ?></span></h2>
                        <p>Ngày lập: <span><?php echo $inv['invoice_created_at']; ?></span></p>
                    </div>
                </div>
                <hr />
                <div class="formto d-flex justify-content-between">
                    <div>
                        <h4>Từ:</h4>
                        <p>FTeam store colthes</p>
                        <p>Long Thạnh Mỹ, Quận 9</p>
                        <p>Thành phố Hồ Chí Minh</p>
                    </div>
                    <div>
                        <h4>Đến:</h4>
                        <p><?php echo $u['user_full_name']; ?></p>
                        <p><?php echo $u['user_phone_number']; ?></p>
                        <p><?php echo $u['user_address']; ?></p>
                    </div>
                </div>
                <!-- <div>
                    <h4>Ghi chú:</h4>
                    <p>hihihihihihihihidhskfbnsdkfn</p>
                </div> -->

                <hr />
                <table class="table table-borderless">
                    <thead class="thead-dark">
                        <tr>
                            <th> Tên sản phẩm</th>
                            <th> Size </th>
                            <th> Số lượng</th>
                            <th> Giá </th>
                            <th>Tạm tính</th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php
                        // $total = 0;
                        foreach ($invoices->getInvoiceDetails(getGET('invoice_id')) as $k => $v) {
                            $total += $v['detail_product_quantity'] * $v['product_price'];
                        ?>
                            <tr>
                                <td><?php echo $v['product_name']; ?></td>
                                <td><?php echo $v['detail_product_size']; ?></td>
                                <td><?php echo $v['detail_product_quantity']; ?></td>
                                <td><?php echo $v['product_price']; ?></td>
                                <td><?php echo formatPrice($v['detail_product_quantity'] * $v['product_price']); ?><span>đ</span></td>
                            </tr>
                        <?php } ?>
                        <!-- <tr>
                            <td> Áo plo</td>
                            <td>x</td>
                            <td>2</td>
                            <td>30000<span>đ</span></td>
                            <td>60000<span>đ</span></td>
                        </tr> -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" align="right"><b>Tổng tiền</b></td>
                            <td><?php echo formatPrice($inv['invoice_total_payment']); ?><span>đ</span></td>
                        </tr>
                    </tfoot>
                </table>
                <hr />
                <p>Phương thức thanh toán: <span>COD</span></p>
            </div>
        </div>

    </div>

    <div class="col-xl-4" id="groupBtnStatus">
        <div class="card">
            <div class="card-body d-xl-flex flex-column justify-content-between">
                <p>Trạng thái hiện tại: <?php echo $inv['invoice_status_name']; ?></p>
                <form method="post" action="">
                    <button class="btn btn-warning mb-xl-2" style="width: 100%;" type="submit" name="invoice_status_id" value="1">Đang chờ</button>
                    <button class="btn btn-danger mb-xl-2" style="width: 100%;" type="submit" name="invoice_status_id" value="2">Đã hủy</button>
                    <button class="btn btn-info mb-xl-2" style="width: 100%;" type="submit" name="invoice_status_id" value="3">Đang giao hàng</button>
                    <button class="btn btn-success mb-xl-2" style="width: 100%;" type="submit" name="invoice_status_id" value="4">Giao hàng thành công</button>
                    <button id="btnPrintBill" class="btn btn-info mb-xl-2" style="width: 100%;">In hóa đơn</button>
                    <a class="btn btn-outline-dark" href="javascript:history.go(-1)" style="width: 100%;">Trở về</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include 'footer.php';
