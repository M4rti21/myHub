<?php
if (isset($_POST["login_submit"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    require_once 'dbh.scr.php';
    require_once 'functions.scr.php';

    if (emptyInputLogin($username, $password) !== false) {
        header("Location: ../../home/login.php?error=emptyInput");
        exit();
    }

    loginUser($conn, $username, $password);
    header("Location: ../../home/index.php");
    exit();

} else {
    header("Location: ../../home/login.php");
    exit();
}
