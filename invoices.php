<?php
include 'header.php';
$users = new User();
$user = $users->getUser($_SESSION['user_id']);
?>
<div class="container-xl history-container py-5 px-5">
    <div class="table-content table-responsive">
        <h2 class="mb-5">Lịch sử mua hàng</h2>
        <table class="table text-center">
            <thead class="border-bottom text-left">
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Ngày mua</th>
                    <th>Địa chỉ giao hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody class="text-left">
                <?php
                $invoices = new Invoice;
                foreach ($invoices->getInvoicesByUserId($_SESSION['user_id'], 0, 0) as $k => $v) {
                ?>
                <tr>
                    <td class="bill-id"><?php echo $v['invoice_id']; ?></td>
                    <td class="bill-date "><?php echo $v['invoice_created_at']; ?></td>
                    <td class="bill-address "><?php echo $user['user_address']; ?></td>
                    <td class="bill-total"><?php echo formatPrice($v['invoice_total_payment']); ?><span> VNĐ</span>
                    </td>
                    <td class="bill-status"><?php echo $v['invoice_status_name']; ?></td>
                    <td class="bill-details"><a
                            href="invoice-details.php?invoice_id=<?php echo $v['invoice_id']; ?>">View details</a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php
include 'footer.php';