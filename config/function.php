<?php
function getPOST($key)
{
    $key = strtolower($key);
    $value = '';
    if (isset($_POST[$key])) {
        $value = $_POST[$key];
    }
    return $value;
}
function getCOOKIE($key)
{
    $key = strtolower($key);
    $value = '';
    if (isset($_COOKIE[$key])) {
        $value = $_COOKIE[$key];
    }
    return $value;
}
function getGET($key)
{
    $key = strtolower($key);
    $value = '';
    if (isset($_GET[$key])) {
        $value = $_GET[$key];
    }
    return $value;
}
function getREQUEST($key)
{
    $key = strtolower($key);
    $value = '';
    if (isset($_REQUEST[$key])) {
        $value = $_REQUEST[$key];
    }
    return $value;
}

function formatPrice($price)
{
    return number_format($price, 0, ',', '.');
}
