<?php
session_start();
if (empty($_SESSION["userId"])) {
    print_r(json_encode("no session"));
} else {
    $me = $_SESSION["userId"];
    $recipient = $_POST["to"];
    require_once 'dbh.scr.php';
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
        print_r(json_encode(mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT) . "error"));
    } else {
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
            print_r(json_encode("nothing"));
        } else {
            print_r(json_encode($rows));
        }
    }
}