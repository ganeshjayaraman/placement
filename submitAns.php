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

if (isset($_POST['id'])) {
    $id = $_SESSION['id'];
    $qid=$_POST['id'];
    $crt=$_POST['ans'];
    if(!strcmp($crt,"undefined")){
        $crt = "";
    }
    if (!empty($qid) && !empty($crt)) {
        // Look up the username and password in the database

        $query1 = "SELECT * from marks WHERE userid ='$id' AND qid = '$qid'";

        $data1 = mysqli_query($sql,$query1);

        if (mysqli_num_rows($data1)== 1) {
            $query = "UPDATE marks SET uans='$crt',updated_at=NOW() WHERE userid = '$id' AND qid = '$qid'";
            $data =mysqli_query($sql,$query);
        }else{
            $query2 = "SELECT * from question WHERE qid ='$qid'";

            $data1 = mysqli_query($sql,$query2);
            if (mysqli_num_rows($data1)== 1) {
                $row = mysqli_fetch_array($data1);
                $correct_one = $row['crt'];
            }
            $query = "INSERT INTO marks(userid,qid,uans,crt,created_at,updated_at) VALUES ('$id','$qid','$crt','$correct_one',NOW(),NOW())";
            $data =mysqli_query($sql,$query);
        }
        $qid++;
        $query3 = "SELECT * from question WHERE qid='$qid'";
        $data3 = mysqli_query($sql,$query3);
        if (mysqli_num_rows($data3)== 1) {
            $row = mysqli_fetch_array($data3);
            $quest = $row['questions'];
            $quest=htmlspecialchars($quest);
            $ans1=$row['ans1'];
            $ans1 = htmlspecialchars($ans1);
            $ans2=$row['ans2'];
            $ans2 = htmlspecialchars($ans2);
            $ans3=$row['ans3'];
            $ans3 = htmlspecialchars($ans3);
            $ans4=$row['ans4'];
            $ans4 = htmlspecialchars($ans4);
            mysqli_close($sql);
            array_push($send,$qid,$quest,$ans1,$ans2,$ans3,$ans4);
            $send = array_map('utf8_encode', $send);
            echo json_encode($send);
        }
    }
    else {
        die("");
    }

}else{
    die("");
}


?>