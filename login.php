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
    <title>Login - Placement Test</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/materialize.min.css">
</head>
<body  data-spy="scroll"  data-target="#navbar-example" onload="Materialize.toast('<span class=&quot;center wow delay-02s animated flash &quot;  data-wow-delay=&quot;2000ms&quot;> Enter here</span>', 3000, 'rounded')" style="background-color: #fafafa !important;">
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
        <div class="col s12 center-align ">
            <a class="waves-effect waves-light btn-large center-align" href="register.php">For Register, Click Here</a>
        </div>
    </div>

</div>
<br>
<br>
<div class="container">
    <!-- Page Content goes here -->
    <div class="row">
        <div class="center-align col s12">
            <h2>Login Panel</h2>
        </div>
        <div class="col s12 center-align ">
            <div class="row">
                <form class="col s12 m8 offset-m2" action="enter.php" name="login" id="login" method="post">
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="email" id="email" type="email" class="validate" required>
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="pass" id="password" type="password" class="validate" required>
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <button class="btn waves-effect waves-light" type="submit" name="submit">Login</button>
                </form>
            </div>
        </div>
    </div>

</div>
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

