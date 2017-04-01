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

if (!isset($_SESSION['email'])) {
    $home_url = 'index.php';
    header('Location: ' . $home_url);
}
$admin = $_SESSION['auth'];
if($admin!=1){
    $home_url = 'index.php';
    header('Location: ' . $home_url);
}

$query = "SELECT count(*) from question";
$data = mysqli_query($sql,$query);
if (mysqli_num_rows($data)== 1) {
    $row = mysqli_fetch_array($data);
    $total_question = $row['count(*)'];
}
$query = "UPDATE marks SET marks= 1 WHERE uans = crt";
$data =mysqli_query($sql,$query);
$usr_hash_map = array();
$rights_usr = array();
$query = "SELECT * FROM login";
$data = mysqli_query($sql,$query);
while ($row = mysqli_fetch_array($data)){
    $usrid = $row['id'];
    $uname = $row['username'];
    $righttime = $row['rights'];
    $usr_hash_map[$usrid]=$uname;
    $rights_usr[$usrid]=$righttime;
}
$usr_details=array();
foreach ($usr_hash_map as $x => $value) {
    $usr_details[$x] = array();
    $query = "SELECT * FROM marks WHERE userid='$x'";
    $data = mysqli_query($sql, $query);
    $usr_details[$x]['qids'] = array();
    $usr_details[$x]['quants_a'] = 0;
    $usr_details[$x]['c_a'] = 0;
    $usr_details[$x]['logical_a'] = 0;
    $usr_details[$x]['verbal_a'] = 0;
    $usr_details[$x]['quants'] = 0;
    $usr_details[$x]['c'] = 0;
    $usr_details[$x]['logical'] = 0;
    $usr_details[$x]['verbal'] = 0;
    while ($row = mysqli_fetch_array($data)) {
        $qid = $row['qid'];
        $marky = $row['marks'];
        array_push($usr_details[$x]['qids'], $qid);
        if ($qid > 0 && $qid < 11) {
            $usr_details[$x]['quants'] += $marky;
            $usr_details[$x]['quants_a'] += 1;
        }
        if ($qid > 10 && $qid < 21) {
            $usr_details[$x]['c'] += $marky;
            $usr_details[$x]['c_a'] += 1;
        }
        if ($qid > 20 && $qid < 31) {
            $usr_details[$x]['logical'] += $marky;
            $usr_details[$x]['logical_a'] += 1;
        }
        if ($qid > 30 && $qid < 41) {
            $usr_details[$x]['verbal'] += $marky;
            $usr_details[$x]['verbal_a'] += 1;
        }
    }

    $query = "SELECT * FROM detail WHERE userid = '$x' ";
    $data = mysqli_query($sql, $query);
    $choice1 = 0;
    if (mysqli_num_rows($data) == 1) {
        $choice1 = 1;
    }
    $usaname = $usr_hash_map[$x];
    $q = $usr_details[$x]['quants'];
    $qa = $usr_details[$x]['quants_a'];
    $c = $usr_details[$x]['c'];
    $ca = $usr_details[$x]['c_a'];
    $v = $usr_details[$x]['verbal'];
    $va = $usr_details[$x]['verbal_a'];
    $l = $usr_details[$x]['logical'];
    $la = $usr_details[$x]['logical_a'];
    $tqa = $qa + $ca + $va + $la;
    $r = $rights_usr[$x];
    $total_mark = $q + $c + $v + $l;
    $avg_total = $total_mark * 100;
	if($total_question == 0){
		$avg_total=0;
	}else{
		$avg_total /= $total_question;	
	}
    
    $avg_total_attented = $total_mark * 100;
	if($tqa == 0){
		$avg_total_attented = 0;
	}else{
		$avg_total_attented /= $tqa;	
	}
    
    if ($choice1 == 0) {

        $query = "INSERT INTO detail(userid,usrname,total_question_attended,quants,verbal,c_program,logical,rights,quants_a,c_a,verbal_a,logical_a,total_quest,total_avg,avg_attended,total_mark)" .
            "VALUES('$x','$usaname','$tqa','$q','$v','$c','$l','$r','$qa','$va','$ca','$la','$total_question','$avg_total','$avg_total_attented','$total_mark')";

    } else {

        $query = "UPDATE detail SET usrname = '$usaname',total_question_attended='$tqa',quants='$q',verbal='$v',c_program='$c'" .
            ",logical='$l',rights='$r',quants_a='$qa',c_a='$ca',verbal_a='$va',logical_a='$la',total_quest='$total_question',total_avg = '$avg_total',avg_attended ='$avg_total_attented',total_mark = '$total_mark' WHERE userid = '$x'";
    }
    $data = mysqli_query($sql, $query);

}
$query = "SELECT * FROM detail WHERE rights = 0 ORDER BY total_mark DESC";
$data = mysqli_query($sql, $query);
$name = array();
$tqa = array();
$total_avg = array();
$avg_a = array();
$total_mark = array();
$quants = array();
$verbal = array();
$c_program = array();
$logical = array();
$quants_a = array();
$c_a = array();
$logical_a = array();
$verbal_a = array();
$total_quest = array();
$radar = 0;
while ($row = mysqli_fetch_array($data)) {

    array_push($name,$row['usrname']);
    array_push($tqa,$row['total_question_attended']);
    array_push($total_avg,$row['total_avg']);
    array_push($avg_a,$row['avg_attended']);
    array_push($total_mark,$row['total_mark']);
    array_push($quants,$row['quants']);
    array_push($verbal,$row['verbal']);
    array_push($c_program,$row['c_program']);
    array_push($logical,$row['logical']);
    array_push($quants_a,$row['quants_a']);
    array_push($c_a,$row['c_a']);
    array_push($logical_a,$row['logical_a']);
    array_push($verbal_a,$row['verbal_a']);
    array_push($total_quest,$row['total_quest']);
    $radar++;
}

mysqli_close($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Dashboard</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/materialize.min.css">
</head>
<body  data-spy="scroll"  data-target="#navbar-example" onload="Materialize.toast('<span class=&quot;center wow delay-02s animated flash &quot;  data-wow-delay=&quot;2000ms&quot;> Welcome Admin</span>', 3000, 'rounded')" style="background-color: #fafafa !important;">
<div class="container" >
    <!-- Page Content goes here -->
    <div class="row">
        <div class="col s12 center-align">
            <p class="flow-text"><h1>Welcome to Placement Training Test Program</h1><a class="waves-effect waves-light btn" href="logout.php">Logout</a>
            <?php if($admin==1){ ?>
                <a class="waves-effect waves-light btn" href="dashboard.php">DashBoard</a>
            <?php } ?>
            </p>
        </div>
        <hr>
    </div>
    <br>
    <br>
    <br>
    <div>
        <!-- Page Content goes here -->
        <div class="row">
            <table class="striped bordered centered">
                <thead>
                <tr>
                    <th data-field="name"><h5>Name</h5></th>
                    <th data-field="name"><h5>Total Mark</h5></th>
                    <th data-field="name"><h5>Total_avg</h5></th>
                    <th data-field="name"><h5>Total_attend</h5></th>
                    <th data-field="name"><h5>Avg_attend</h5></th>
                    <th data-field="name"><h5>quants</h5></th>
                    <th data-field="name"><h5>quants attend</h5></th>
                    <th data-field="name"><h5>Logical</h5></th>
                    <th data-field="name"><h5>Logical attend</h5></th>

                    <th data-field="name"><h5>C</h5></th>
                    <th data-field="name"><h5>C attend</h5></th>

                    <th data-field="name"><h5>Verbal</h5></th>
                    <th data-field="name"><h5>Verbal attend</h5></th>
                </tr>
                </thead>
                <tbody id="leaderboard">
                <?php
                for($i=0;$i<$radar;$i++){
                ?>
                <tr>
                    <td><?php echo $name[$i] ; ?></td>
                    <td><?php echo $total_mark[$i]; ?></td>
                    <td><?php echo $total_avg[$i]; ?></td>
                    <td><?php echo $tqa[$i]; ?></td>
                    <td><?php echo $avg_a[$i]; ?></td>
                    <td><?php echo $quants[$i]; ?></td>
                    <td><?php echo $quants_a[$i]; ?></td>
                    <td><?php echo $logical[$i]; ?></td>
                    <td><?php echo $logical_a[$i]; ?></td>
                    <td><?php echo $c_program[$i]; ?></td>
                    <td><?php echo $c_a[$i]; ?></td>
                    <td><?php echo $verbal[$i]; ?></td>
                    <td><?php echo $verbal_a[$i]; ?></td>
                </tr>
<?php } ?>
                </tbody>
            </table>
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
    <script src="js/util.js"></script>
    <script src="js/enclose.js"></script>
</body>
</html>

