<?php
include 'config/config.php';

$user = new User;
$user->endSession();

header('Location: ./');