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
    if (!empty($qid)) {
        $query3 = "SELECT * from question WHERE qid='$qid'";
        $query1 = "SELECT * from marks WHERE userid ='$id' AND qid = '$qid'";

        $data1 = mysqli_query($sql,$query1);

        if (mysqli_num_rows($data1)== 1) {
            $row1 = mysqli_fetch_array($data1);
            $uans = $row1['uans'];
        }else{
            $uans = "santhosh";
        }

        $data3 = mysqli_query($sql,$query3);
        if (mysqli_num_rows($data3)== 1) {
            $row = mysqli_fetch_array($data3);
            $quest = $row['questions'];
            $quest=htmlspecialchars($quest);
            $choice = 0;
            $ans1=$row['ans1'];
            if(!substr_compare($ans1,$uans,0)){
                $choice = 1;
            }
            $ans1 = htmlspecialchars($ans1);
            $ans2=$row['ans2'];
            if(!substr_compare($ans2,$uans,0)){
                $choice = 2;
            }
            $ans2 = htmlspecialchars($ans2);
            $ans3=$row['ans3'];
            if(!substr_compare($ans3,$uans,0)){
                $choice = 3;
            }
            $ans3 = htmlspecialchars($ans3);
            $ans4=$row['ans4'];
            if(!substr_compare($ans4,$uans,0)){
                $choice = 4;
            }
            $ans4 = htmlspecialchars($ans4);
            mysqli_close($sql);
            array_push($send,$qid,$quest,$ans1,$ans2,$ans3,$ans4,$choice);
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