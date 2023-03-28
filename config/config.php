<?php
error_reporting(0); //Dòng tắt báo lỗi
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();

define('DB_HOST', '103.200.23.139'); //localhost
define('DB_USER', 'fteamlpt'); //root
define('DB_PASS', 'Fteamlp.top@123');
define('DB_NAME', 'fteamlpt_clothes');
define('DATA_PER_PAGE', 9);
define('ADMIN_PASSWORD', '123456');

require_once('function.php');
require_once('class.php');
new DB();
