<?php
session_start();
if (isset($_POST["soc_submit"])) {
    if (empty($_SESSION["userId"])) {
        header("Location: ../../profile");
        exit();
    }
    require_once 'dbh.scr.php';
    require_once 'functions.scr.php';
    if (!empty($_POST["socialId"] || !empty($_POST["usrSocialName"]))) {
            updateSocial($conn, $_POST["socialId"], $_POST["usrSocialName"]);
    }
    exit();
} else {
    header("Location: ../../profile");
    exit();
}