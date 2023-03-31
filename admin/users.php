<?php
include 'header.php';

$users = new User;
?>
<div class="container-fluid px-4">
    <h1 class="my-4">Quản lý khách hàng</h1>

    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Khách hàng
                </div>
                <div class="card-body">
                    <table id="datatablesCustomer" class="table-responsive">
                        <thead>
                            <tr>
                                <th>Tên khách hàng</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users->getUsers() as $k => $v) { ?>
                                <tr>
                                    <td><?php echo $v['user_full_name']; ?></td>
                                    <td><?php echo $v['user_email']; ?></td>
                                    <td><?php echo $v['user_phone_number']; ?></td>
                                    <td><?php echo $v['user_address']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'footer.php';
