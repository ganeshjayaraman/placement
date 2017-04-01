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

if(!isset($_SESSION['start_quiz'])){
    $query = "SELECT * FROM login WHERE id = '$id'";
    $data = mysqli_query($sql,$query);
    if (mysqli_num_rows($data)== 1) {
        // The log-in is OK so set the user ID and username session vars (and cookies), and redirect to the home page
        $row = mysqli_fetch_array($data);
        $start=$row['start_quiz'];
        $timerMilli = $row['test_time'];
        if(empty($timerMilli)){
            $timerMilli = "00: 40:00";
        }
    }
    if($start == 1){
        $home_url = 'index.php';
        header('Location: ' . $home_url);
    }
    $_SESSION['start_quiz']="1";
    $query = "UPDATE login SET start_quiz=1 WHERE id = '$id'";
    $data =mysqli_query($sql,$query);
}else{
    $home_url = 'index.php';
    header('Location: ' . $home_url);
}

$timerMilli1 = $timerMilli;
list($hour,$min,$sec)=explode(":",$timerMilli);
$hour=trim($hour);
$min=trim($min);
$sec=trim($sec);
$questArray = array();
//$timerMilli = mktime(0,0,0,$hour,$min,$sec);
$timerMilli=$timerMilli1;
if (!isset($_SESSION['email'])) {
    $home_url = 'index.php';
    header('Location: ' . $home_url);
}
$admin = $_SESSION['auth'];
$query = "SELECT * FROM marks WHERE userid = '$id'";
$data = mysqli_query($sql,$query);
while($row = mysqli_fetch_assoc($data))
{
    array_push($questArray,$row['qid']);
}
 $query = "SELECT * FROM question WHERE qid = 1";
$data = mysqli_query($sql,$query);
if (mysqli_num_rows($data)== 1) {
    // The log-in is OK so set the user ID and username session vars (and cookies), and redirect to the home page
    $row = mysqli_fetch_array($data);
    $qid = $row['qid'];
    $question = $row['questions'];
    $ans1=$row['ans1'];
    $ans2=$row['ans2'];
    $ans3=$row['ans3'];
    $ans4=$row['ans4'];
    mysqli_close($sql);
}else{
    echo 'Sorry, something went wrong :( Kindly contact Representing faculty.';
    header("Refresh:2; url=index.php", true, 303);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Placement Test - HomeComing</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/materialize.min.css">
</head>
<body  data-spy="scroll"  data-target="#navbar-example" onload="initiated()" style="background-color: #fafafa !important;">
<div class="navbar-fixed">
    <nav  id="navbar-example" role=navigation>
        <ul id="dropdown1" class="dropdown-content">
            <li><a href="logout.php" style="font-size: x-large">Log out</a></li>
        </ul>
        <div class="nav-wrapper teal">
            <span style="font-size: x-large">&nbsp;&nbsp;Placement Training Test</span>
            <a href="#" data-activates="mobxile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li><div class="large-text btn btn-danger" id="timer"><?php echo $timerMilli; ?></div></li>
                <li><a class="dropdown-button"  style="font-size: x-large" href="#" data-activates="dropdown1"><?php echo $_SESSION['email']; ?><i class="material-icons right">arrow_drop_down</i></a></li>

            </ul>
            <ul class="side-nav" id="mobile-demo"><br>
                <li><div class="large flow-text btn btn-danger" id="timer"><?php echo $timerMilli; ?></div></li><br>
                <li><a class="dropdown-button"  style="font-size: x-large" href="#" data-activates="dropdown1"><?php echo $_SESSION['email']; ?><i class="material-icons right">arrow_drop_down</i></a></li>

            </ul>
        </div>
    </nav>
</div>

<div>
    <!-- Page Content goes here -->
    <div class="row">
        <div class="col s3">
            <div class="divider"></div>
            <div class="section">
                <h4><a href="#" onclick="gotosubmit(1)">Quants</a></h4>
            </div>
            <div class="divider"></div>
            <div class="section">
                <h4><a href="#" onclick="gotosubmit(11)">C Program</a></h4>
            </div>
            <div class="divider"></div>
            <div class="section">
                <h4><a href="#" onclick="gotosubmit(21)">Logical</a></h4>
            </div>
            <div class="divider"></div>
            <div class="section">
                <h4><a href="#" onclick="gotosubmit(31)">Verbal</a></h4>
            </div>
        </div>
        <div class="col s6">

            <div class="row">
                <h1>Question No. <span id="dispqno">1</span></h1>
                <h3 id="dispquest"><?php echo $question; ?></h3>
            </div>
            <div class="divider"></div>
            <div class="row">
                <form action="#">
                    <p>
                        <input id="in1" name="group1" value="<?php echo $ans1; ?>" type="radio"  />
                        <label id="lab1" for="in1" style="font-size: 2rem"><?php echo $ans1; ?></label>
                    </p>
                    <p>
                        <input id="in2" name="group1" value="<?php echo $ans2; ?>" type="radio" />
                        <label id="lab2" for="in2"  style="font-size: 2rem"><?php echo $ans2; ?></label>
                    </p>
                    <p>
                        <input name="group1" value="<?php echo $ans3; ?>" type="radio" id="in3"  />
                        <label id="lab3"for="in3" style="font-size: 2rem"><?php echo $ans3; ?></label>
                    </p>
                    <p>
                        <input name="group1" value="<?php echo $ans4; ?>" type="radio" id="in4" />
                        <label id="lab4" for="in4" style="font-size: 2rem"><?php echo $ans4; ?></label>
                    </p>
                </form>

            </div>
            <div class="divider"></div>
            <br>
            <a id="submitEnd" class="waves-effect waves-light btn-large center-align" name="submit" onclick="submitData()" href="#">Submit</a>&nbsp;&nbsp;
            <a class="waves-effect waves-light btn-large center-align" onclick="clearOptions()" href="#">Clear</a>&nbsp;&nbsp;
            <a style="display:none" id="fs" class="waves-effect waves-light btn-large center-align" href="#" onclick="exiton()">Final Submit</a>


        </div>
        <div class="col s3">
            <div class="divider"></div>
            <div class="section">
                <h5><a href="#" onclick="gotosubmit(1)">Quants</a></h5>
                <h6>
                    <?php
                        for($i=1;$i<11;$i++)
                            echo "<a id = \"qid$i\" onclick=\"gotosubmit($i)\" style=\"margin: 5px;\" class = \"waves-effect waves-light btn-flat\">$i</a>";
                    ?>

                </h6>

            </div>
            <div class="divider"></div>
            <div class="section">
                <h5><a href="#" onclick="gotosubmit(11)">C Program</a></h5>
                <h6>
                    <?php
                    for($i=11;$i<21;$i++)
                        echo "<a id = \"qid$i\" onclick=\"gotosubmit($i)\" style=\"margin: 5px;\" class = \"waves-effect waves-light btn-flat\">$i</a>";
                    ?>

                </h6>
            </div>
            <div class="divider"></div>
            <div class="section">
                <h5><a href="#" onclick="gotosubmit(21)">Logical</a></h5>
                <h6>
                    <?php
                    for($i=21;$i<31;$i++)
                        echo "<a id = \"qid$i\"   onclick=\"gotosubmit($i)\"  style=\"margin: 5px;\" class = \"waves-effect waves-light btn-flat\">$i</a>";
                    ?>

                </h6>
            </div>
            <div class="divider"></div>
            <div class="section">
                <h5><a href="#" onclick="gotosubmit(31)">Verbal</a></h5>
                <h6>
                    <?php
                    for($i=31;$i<41;$i++)
                        echo "<a id = \"qid$i\" onclick=\"gotosubmit($i)\" style=\"margin: 5px;\" class = \"waves-effect waves-light btn-flat\">$i</a>";
                    ?>

                </h6>
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

<script>
    var id=<?php echo $qid; ?>;
    var arrayQues=[];
    function initiated(){
        Materialize.toast('<span class=&quot;center wow delay-02s animated flash &quot;  data-wow-delay=&quot;2000ms&quot;> Good Luck !!!</span>', 3000, 'rounded');
        <?php
        for($i=0;$i<count($questArray);$i++){
        ?>
        arrayQues.push(<?php echo $questArray[$i];  ?>);
        <?php
        }
            ?>

        var questlen = arrayQues.length;
        for(i=0;i<questlen;i++){
            var qidd = document.getElementById("qid"+arrayQues[i]);
            var cname=qidd.className;
            cname = cname+" teal";
            qidd.className=cname;
        }



    }
</script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/materialize.min.js"></script>
<script src="js/util.js"></script>
<script src="js/submit.js"></script>

<script type="text/javascript">

    var millis = "<?php echo $timerMilli; ?>";
    var hours=<?php echo $hour; ?>;
    var timeMilli;
    mins=<?php echo $min; ?>;
    secs= <?php echo $sec; ?>;
    /*localStorage.setItem("millis",millis);
    localStorage.setItem("hours", hours);
    localStorage.setItem("mins", mins);
    localStorage.setItem("secs", secs);*/

    function displaytimer(){
/*
        mins = localStorage.getItem("mins");
        secs = localStorage.getItem("secs");*/
        //Here, the DOM that the timer will appear using jQuery
        if(secs <10 || mins < 10 || hours < 10){
            if(secs < 10){
                timeMilli=hours+': '+mins+': 0'+secs;
                $('#timer').html(hours+': '+mins+': 0'+secs);
                if(mins < 10){
                    timeMilli=hours+': 0'+mins+': 0'+secs;
                    $('#timer').html(hours+': 0'+mins+': 0'+secs);
                    if(hours < 10){
                        timeMilli='0'+hours+': 0'+mins+': 0'+secs;
                        $('#timer').html('0'+hours+': 0'+mins+': 0'+secs);
                    }
                }

            }
            if(mins < 10){
                timeMilli=hours+': 0'+mins+':'+secs;
                $('#timer').html(hours+': 0'+mins+':'+secs);
                if(secs < 10){
                    timeMilli=hours+': 0'+mins+':'+secs;
                    $('#timer').html(hours+': 0'+mins+': 0'+secs);
                    if(hours < 10){
                        timeMilli='0'+hours+': 0'+mins+': '+secs;
                        $('#timer').html('0'+hours+': 0'+mins+': '+secs);
                    }
                }
            }
            if(hours < 10){
                timeMilli='0'+hours+': '+mins+':'+secs
                $('#timer').html('0'+hours+': '+mins+':'+secs);
                if(mins < 10){
                    timeMilli='0'+hours+': 0'+mins+': '+secs;
                    $('#timer').html('0'+hours+': 0'+mins+': '+secs);
                    if(secs < 10){
                        timeMilli='0'+hours+': 0'+mins+': 0'+secs;
                        $('#timer').html('0'+hours+': 0'+mins+': 0'+secs);
                    }
                }
            }
        }
        else{
            timeMilli=hours+':'+mins+':'+secs;
            $('#timer').html(hours+':'+mins+':'+secs);
        }


        if(secs>0){
            secs-= 1;
        }
        else if(mins>0){
            if(secs == 0){
                secs = 59;
                mins -=1;
            }
        }

        else if(hours>0){
            mins = 59;
            secs = 59;
            hours -= 1;
        }

        else
            ;
//			window.location = "login.php";
        if(mins == 5 && secs == 0){
            setInterval(function(){
                alert("Hurry! Only 5 Mins left");
            },3000);

        }
        if(mins == 0 && secs == 0){
         //   document.getElementById("timer").className = "btn btn-danger";
            //alert("Thank you for Participating Results will be announced in Admin DashBoard");
            window.location="dashboard.php";
        }
    }

    function goodbye(e) {
        if(!e) e = window.event;
        //e.cancelBubble is supported by IE - this will kill the bubbling process.
        e.cancelBubble = true;
        e.returnValue = 'You sure you want to leave/refresh this page?';


        //e.stopPropagation works in Firefox.
        if (e.stopPropagation) {
            e.stopPropagation();
            e.preventDefault();
        }
    }

    window.onbeforeunload=goodbye;

    setInterval(function(){
       // millis -= 1000;
        displaytimer();
        eraseCookie("millis");/*
        eraseCookie("min");
        eraseCookie("sec");*/
        createCookie("millis",timeMilli,1);
//        createCookie("min",mins,1);
//        createCookie("sec",secs,1);
        /*
        localStorage.setItem("millis",millis);
        localStorage.setItem("hours", hours);
        localStorage.setItem("mins", mins);
        localStorage.setItem("secs", secs);*/
    }, 1000);
    function createCookie(name,value,days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime()+(days*24*60*60*1000));
            var expires = "; expires="+date.toGMTString();
        }
        else var expires = "";
        document.cookie = name+"="+value+expires+"; path=/";
    }
    

    function eraseCookie(name) {
        createCookie(name,"",-1);
    }
</script>
<script type="text/javascript">
    /*window.onbeforeunload = function() {
        return "Dude, are you sure you want to leave? Think of the kittens!";
    }*/
</script>
</body>
</html>
