<?php
//Database Connection Code
require_once('dbConnect.php');
$sql = dbConnect();
session_start();
if(!isset($_SESSION['email'])) {
    if (isset($_COOKIE['email']) && isset($_COOKIE['auth'])&& isset($_COOKIE['id'])) {
        $_SESSION['email'] = $_COOKIE['email'];
        $_SESSION['auth'] = $_COOKIE['auth'];
        $_SESSION['id'] = $_COOKIE['id'];
    }
}
$send=array();
if (!isset($_SESSION['email'])) {
    die("");
}

if (isset($_GET['t'])) {
    
    }
    



}
?>