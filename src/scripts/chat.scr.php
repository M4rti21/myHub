<?php
session_start();
if (empty($_SESSION["userId"])) {
    echo "bruh";
} else {
    require_once 'dbh.scr.php';
    $msg = htmlspecialchars($_POST["msg"]);
    $reciever = $_POST["to"];
    $sender = $_SESSION["userId"];
    $date = date('Y-m-d H:i:s', time());
    $sql = "INSERT INTO chatMsg (reciever, sender, txt, hora) VALUES ('$reciever', '$sender', '$msg' ,'$date')";
    if (!mysqli_query($conn, $sql)) {
        echo "Error";
    } else {
        echo json_encode("message sent");
    }
    mysqli_close($conn);
}