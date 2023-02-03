<?php
function emptyInputSignup($username, $email, $password, $password_repeat, $birthday, $gender)
{
    if (empty($username) || empty($email) || empty($password) || empty($password_repeat) || empty($birthday) || empty($gender)) {
        return true;
    } else {
        return false;
    }
}

function invalidUsername($username)
{
    if (!preg_match("/[^a-zA-Z0-9-_]*$/", $username)) {
        return true;
    } else {
        return false;
    }
}

function invalidEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function pwdMatch($password, $password_repeat)
{
    if ($password !== $password_repeat) {
        return true;
    } else {
        return false;
    }
}

function userExists($conn, $username, $email)
{
    $sql = "SELECT * FROM users WHERE userName = ? OR userEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../home/signup.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        return false;
    }
    mysqli_stmt_close($stmt);
}

function createUser($conn, $username, $email, $password, $birthday, $gender)
{
    $sql = "INSERT INTO users (userName, userEmail, userPwd, userBdate, userGender) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../home/signup.php?error=stmtFailed");
        exit();
    }
    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $hashedPwd, $birthday, $gender);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: ../../home/signup.php?error=none");
    exit();
}

function emptyInputLogin($username, $password)
{
    if (empty($username) || empty($password)) {
        return true;
    } else {
        return false;
    }
}

function loginUser($conn, $username, $password)
{
    $uidExists = userExists($conn, $username, $username);
    if ($uidExists === false) {
        header("Location: ../../home/login.php?error=wrongLogin");
        exit();
    }

    $pwdHashed = $uidExists["userPwd"];
    $checkPwd = password_verify($password, $pwdHashed);

    if ($checkPwd === false) {
        header("Location: ../../home/login.php?error=wrongLogin");
        exit();
    } else {
        session_start();
        $_SESSION["userId"] = $uidExists["userId"];
        $_SESSION["userName"] = $uidExists["userName"];
        $_SESSION["userImage"] = $uidExists["userImage"];
        $_SESSION["userBanner"] = $uidExists["userBanner"];
        $_SESSION["userDesc"] = $uidExists["userDescription"];
    }
}

function updatePfp($fileLocation, $conn)
{
    $sql = "UPDATE users SET userImage = ? WHERE userId = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../profiles/userpage.php?usr=".$_SESSION["userId"]."&error=stmtFailed");
        exit();
    }
    $usrId = strval($_SESSION["userId"]);
    mysqli_stmt_bind_param($stmt, "ss", $fileLocation, $usrId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $_SESSION["userImage"] = $fileLocation;
    header('Cache-Control: no-cache');
    header('Pragma: no-cache');
    header("Location: ../../profiles/userpage.php?usr=".$_SESSION["userId"]."&error=none");
    exit();
}

function updateBanner($fileLocation, $conn)
{
    $sql = "UPDATE users SET userBanner = ? WHERE userId = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../profiles/userpage.php?usr=".$_SESSION["userId"]."&errorB=stmtFailed");
        exit();
    }
    $usrId = strval($_SESSION["userId"]);
    mysqli_stmt_bind_param($stmt, "ss", $fileLocation, $usrId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $_SESSION["userBanner"] = $fileLocation;
    header('Cache-Control: no-cache');
    header('Pragma: no-cache');
    header("Location: ../../profiles/userpage.php?usr=".$_SESSION["userId"]."&errorB=stmtFailed");
    exit();
}

function updateDesc($fileName, $conn)
{
    $sql = "UPDATE users SET userDescription = ? WHERE userId = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../../profiles/edit.php?errorD=stmtFailed");
        exit();
    }
    $usrId = strval($_SESSION["userId"]);
    mysqli_stmt_bind_param($stmt, "ss", $fileName, $usrId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header('Cache-Control: no-cache');
    header('Pragma: no-cache');
    header("Location: ../../profiles/edit.php?errorD=none");
    exit();
}

function updateSocial($conn, $socialId, $socialUsrName)
{
    $userId = strval($_SESSION["userId"]);
    $ask = "SELECT * FROM userSocials WHERE userId = ? AND socialId = ?";
    $stmt2 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt2, $ask)) {
        header("Location: ../../profiles/userpage.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt2, "ss", $userId, $socialId);
    mysqli_stmt_execute($stmt2);
    $resultData = mysqli_stmt_get_result($stmt2);
    mysqli_stmt_close($stmt2);

    if (mysqli_fetch_assoc($resultData)) {
        $sql = "UPDATE userSocials SET socialUsrName = ? WHERE userId = ? AND socialId = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../../profiles/userpage.php?usr=" . $userId . "&error=stmt1Failed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "sss", $socialUsrName, $userId, $socialId);
    } else {
        $sql = "INSERT INTO userSocials (userId, socialId, socialUsrName) VALUES (?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../../profiles/userpage.php?usr=" . $userId . "&error=stmt2Failed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "sss", $userId, $socialId, $socialUsrName);
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: ../../profiles/userpage.php?usr=" . $userId ."&edit=1");
    exit();
}

function removeSocial($conn, $socialId)
{
    $userId = strval($_SESSION["userId"]);
    $ask = "DELETE FROM userSocials WHERE userId = ? AND socialId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $ask)) {
        header("Location: ../../profiles/userpage.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $userId, $socialId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: ../../profiles/userpage.php?usr=" . $userId ."&edit=1");
    exit();
}