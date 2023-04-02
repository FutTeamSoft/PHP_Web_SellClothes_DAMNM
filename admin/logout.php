<?php
include '../config/config.php';

Admin::endSession();
header('Location: login.php');
