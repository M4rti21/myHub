<?php
session_start();
if (isset($_POST["uploadD_submit"])) {
    if (empty($_SESSION["userId"])) {
        header("Location: ../../userpage.php");
        exit();
    }
    $desc = htmlspecialchars($_POST["descriptionBox"]);
    if ($desc > 4000) {
        header("Location: ../../profile/edit.php?errorD=tooMuchTxt");
        exit();
    }
    require_once 'dbh.scr.php';
    require_once 'functions.scr.php';
    $fileName = "../user_desc/".$_SESSION["userId"]."-desc.txt";
    $txt = fopen($fileName, "w");
    fwrite($txt, $desc);
    fclose($txt);
    updateDesc($fileName, $conn);
    $_SESSION["userDesc"] = $fileName;
    exit();
} else {
    header("Location: ../../profile/edit.php");
    exit();
}