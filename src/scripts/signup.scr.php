<?php
if (isset($_POST["signup_submit"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_repeat = $_POST["password_repeat"];
    $birthday = date('Y-m-d', strtotime($_POST["birthday"]));
    $gender = $_POST["gender"];
    
    require_once 'dbh.scr.php';
    require_once 'functions.scr.php';

    if (emptyInputSignup($username, $email, $password, $password_repeat, $birthday, $gender) !== false) {
        header("Location: ../../home/signup.php?error=emptyInput&username=".$username."&email=".$email."&birthday=".$birthday."&gender=".$gender);
        exit();
    }
    if (invalidUsername($username) !== false) {
        header("Location: ../../home/signup.php?error=invalidUsername&email=".$email."&birthday=".$birthday."&gender=".$gender);
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("Location: ../../home/signup.php?error=invalidEmail&username=".$username."&birthday=".$birthday."&gender=".$gender);
        exit();
    }
    if (pwdMatch($password, $password_repeat) !== false) {
        header("Location: ../../home/signup.php?error=emptyInput&username=".$username."&email=".$email."&birthday=".$birthday."&gender=".$gender);
        exit();
    }
    if (userExists($conn, $username, $username) !== false) {
        header("Location: ../../home/signup.php?error=usernameTaken&email=".$email."&birthday=".$birthday."&gender=".$gender);
        exit();
    }
    if (userExists($conn, $email, $email) !== false) {
        header("Location: ../../home/signup.php?error=emailTaken&username=".$username."&birthday=".$birthday."&gender=".$gender);
        exit();
    }

    createUser($conn, $username, $email, $password, $birthday, $gender);

} else {
    header("Location: ../../home/signup.php");
    exit();
}