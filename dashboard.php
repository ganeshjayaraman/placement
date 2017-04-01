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
$id = $_SESSION['id'];
if(isset($_COOKIE['millis'])){
    $millis = $_COOKIE['millis'];
    $query = "UPDATE login SET test_time = '$millis' WHERE id = '$id'";
    $data =mysqli_query($sql,$query);
}
if (!isset($_SESSION['email'])) {
    $home_url = 'index.php';
    header('Location: ' . $home_url);
}
$admin = $_SESSION['auth'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>HomeComing - Dashboard</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/materialize.min.css">
</head>
<body  data-spy="scroll"  data-target="#navbar-example" onload="Materialize.toast('<span class=&quot;center wow delay-02s animated flash &quot;  data-wow-delay=&quot;2000ms&quot;> Welcome <?php echo $_SESSION['email']; ?></span>', 3000, 'rounded')" style="background-color: #fafafa !important;">
<div class="container" >
    <!-- Page Content goes here -->
    <div class="row">
        <div class="col s12 center-align">
            <p class="flow-text"><h1>Welcome to Placement Training Test Program</h1><a class="waves-effect waves-light btn" href="logout.php">Logout</a>
            <?php if($admin==1){ ?>
                <a class="waves-effect waves-light btn" href="admin.php">Admin</a>
            <?php } ?>
            </p>
        </div>
        <hr>
    </div>
    <br>
    <br>
    <br>
    <div class="container">
        <!-- Page Content goes here -->
        <div class="row">
            <div class="col s12 center-align ">
                <a class="waves-effect waves-light btn-large center-align" href="homecoming.php">Take Test</a>
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
