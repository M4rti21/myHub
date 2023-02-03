<?php
require_once 'dbh.scr.php';
if (!empty($_POST["uid"])) {
    $key = $_POST["uid"];
    $sql = "SELECT userId
        FROM users where userId = '$key'
        LIMIT 1";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT)."error";
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    function resultToArray2($result)
    {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    $result = $conn->query($sql);
    $rows = resultToArray2($result);
    $result->free();
    if (empty($rows)) {
        print_r(json_encode(false));
    } else {
        print_r(json_encode(true));
    }
    exit();
} else if (!empty($_POST["uname"])) {
    $key = $_POST["uname"];
    $sql = "SELECT userId
        FROM users where userName = '$key'
        LIMIT 1";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT)."error";
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    function resultToArray3($result)
    {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    $result = $conn->query($sql);
    $rows = resultToArray3($result);
    $result->free();
    if (empty($rows)) {
        print_r(json_encode(false));
    } else {
        print_r(json_encode($rows));
    }
    exit();
} else {
    print_r(json_encode(false));
    exit();
}