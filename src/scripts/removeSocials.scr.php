<?php
session_start();
if (isset($_POST["updateSocials_submit"])) {
    if (empty($_SESSION["userId"])) {
        header("Location: ../home/");
        exit();
    }

    require_once 'dbh.scr.php';
    require_once 'functions.scr.php';

    $toRem = $_POST["socIdRem"];
    if (!empty($toRem)) {
        removeSocial($conn, $toRem);
    }
    exit();
} else {
    header("Location: ../home/index.php?aaa");
    exit();
}