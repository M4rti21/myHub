<?php
session_start();
if (empty($_SESSION["userId"])) {
    header("Location: ../../userpage.php");
    exit();
}

include_once 'dbh.scr.php';
require_once 'functions.scr.php';
$target_dir = "../user_images/";
$file = $_FILES['file'];
$fileName = $_FILES['file']['name'];
$fileTmpName = $_FILES['file']['tmp_name'];
$fileSize = $_FILES['file']['size'];
$fileError = $_FILES['file']['error'];
$fileExt = explode('.', $fileName);
$fileActualExt = strtolower(end($fileExt));
$allowed = array('jpg', 'jpeg', 'png', 'gif');

if (!in_array($fileActualExt, $allowed)) {
    header("Location: ../../profiles/userpage.php?usr=" . $_SESSION["userId"] . "&errorB=fileError");
    exit();
}
if ($fileError !== 0) {
    header("Location: ../../profiles/userpage.php?usr=" . $_SESSION["userId"] . "&errorB=fileCorrupted");
    exit();
}
if ($fileSize > 5000000) {
    header("Location: ../../profiles/userpage.php?usr=" . $_SESSION["userId"] . "&errorB=fileTooBig");
    exit();
}

$fileNameNew = $_SESSION["userId"] . "-banner." . $fileActualExt;
$fileLocation = $target_dir . $fileNameNew;

move_uploaded_file($fileTmpName, "../" . $fileLocation);
updateBanner($fileLocation, $conn);
exit();