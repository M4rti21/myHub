<?php
function getThing($search, $conn)
{
    $sql = "SELECT * FROM " . $search . ";";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return 'error';
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    function resultToArray($result)
    {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    $result = $conn->query($sql);
    $rows = resultToArray($result);
    $result->free();
    return $rows;
    exit();
}

function getSocials($conn)
{
    $sql = "SELECT * FROM socials ORDER BY socialId;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return 'error';
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    function resultToArray($result)
    {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    $result = $conn->query($sql);
    $rows = resultToArray($result);
    $result->free();
    return $rows;
    exit();
}

function getUsers($start)
{
    require_once 'dbh.scr.php';
    $start -= 1;
    $start *= 10;
    $sql = "SELECT userId, userName, userImage FROM users limit 10 OFFSET " . $start . ";";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../home/index.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    function resultToArray($result)
    {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    $result = $conn->query($sql);
    $rows = resultToArray($result);
    $result->free();
    return $rows;
    exit();
}

function getSocialsLeft($conn)
{
    $sql = "SELECT * FROM socials WHERE socialId NOT IN ( SELECT socialId FROM userSocials WHERE userId = ?)";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    $userId = strval($_SESSION["userId"]);
    mysqli_stmt_bind_param($stmt, "s", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    if (mysqli_num_rows($result) == 0) {
        return 'empty';
    } else {
        return $rows;
    }
    exit();
}

function getChats($conn)
{
    require_once 'dbh.scr.php';
    $me = $_SESSION["userId"];
    $sql = "SELECT DISTINCT reciever as other, u.userName as userName, u.userImage as userImage
	    FROM chatMsg JOIN users u on userId = chatMsg.reciever
            WHERE sender = '$me'
            UNION
            SELECT DISTINCT sender, u.userName as userName, u.userImage as userImage
            FROM chatMsg JOIN users u on userId = chatMsg.sender
	    WHERE reciever = '$me'";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../home/index.php?error=stmtFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    function resultToArray($result)
    {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
    $result = $conn->query($sql);
    $rows = resultToArray($result);
    $result->free();
    return $rows;
    exit();
}

function getChatMsg($recipient, $conn)
{
    require_once 'dbh.scr.php';
    $me = $_SESSION["userId"];
    $sql = "SELECT sender, txt, msgId, hora, u.userId as senderId, u.userName as senderName, u2.userId as recieverId, u2.userName as recieverName
            FROM chatMsg join users u on u.userId = chatMsg.sender join users u2 on u2.userId = chatMsg.reciever
            WHERE sender = '$me' AND reciever = '$recipient'
            UNION
            SELECT sender, txt, msgId, hora, u.userId as senderId, u.userName as senderName, u2.userId as recieverId, u2.userName as recieverName
            FROM chatMsg join users u on u.userId = chatMsg.sender join users u2 on u2.userId = chatMsg.reciever
            WHERE reciever = '$me' AND sender = '$recipient'
            ORDER BY msgId";
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
        return "nothing";
    } else {
        return $rows;
    }
    exit();
}


function getOtherInfo($recipient, $conn)
{
    require_once 'dbh.scr.php';
    $sql = "SELECT userName, userImage, userId
            FROM users
            WHERE userId = '$recipient'
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
        return "nothing";
    } else {
        return $rows;
    }
    exit();
}
