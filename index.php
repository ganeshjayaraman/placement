<?php
//Database Connection Code
require_once('dbConnect.php');
$sql = dbConnect();
session_start();
if (!isset($_SESSION['email'])) {
    if (isset($_COOKIE['email']) && isset($_COOKIE['auth'])&& isset($_COOKIE['id'])) {
        $_SESSION['email'] = $_COOKIE['email'];
        $_SESSION['auth'] = $_COOKIE['auth'];
        $_SESSION['id'] = $_COOKIE['id'];
    }
}
if (isset($_SESSION['email'])) {
    $home_url = 'dashboard.php';
    header('Location: ' . $home_url);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Placement Test</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/materialize.min.css">
</head>
<body  data-spy="scroll"  data-target="#navbar-example" onload="Materialize.toast('<span class=&quot;center wow delay-02s animated flash &quot;  data-wow-delay=&quot;2000ms&quot;> Welcome to Placement Training Pro Website!!!</span>', 3000, 'rounded')" style="background-color: #fafafa !important;">
<div class="container">
    <!-- Page Content goes here -->
    <div class="row">
        <div class="col s12"> <p class="flow-text"><h1>Welcome to Placement Training Test Program</h1></p></div>
        <hr>
    </div>

</div>
<br>
<br>
<br>
<div class="container">
    <!-- Page Content goes here -->
    <div class="row">
        <div class="col s6 center-align ">
            <a class="waves-effect waves-light btn-large" href="login.php">Login</a>
        </div>
        <div class="col s6 center-align ">
            <a class="waves-effect waves-light btn-large center-align" href="register.php">Register</a>
        </div>
    </div>

</div>
<br>
<br>
<br>
<div class="divider"></div>
<br>
<div class="container">
    <h3> © 2016 Placement Training </h3>
</div>



<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/materialize.min.js"></script>
</body>
</html>

