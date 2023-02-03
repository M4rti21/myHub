<?php
function searchUser ($pageUserId, $conn) {
    $sql = "SELECT userId, userName, userImage, userBanner, userDescription FROM users WHERE userId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../profile/.php?usr=".$_SESSION["userId"]);
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $pageUserId);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    mysqli_stmt_close($stmt);
    return $row;
}

function searchUserSocials($pageUserId, $conn)
{
    $query = "SELECT socials.socialName, socials.socialIcon, socials.socialColor, userSocials.socialUsrName, socials.profUrl, socials.socialId 
            FROM userSocials JOIN socials on socials.socialId = userSocials.socialId 
            WHERE userSocials.userId = ".$pageUserId;
    $result = mysqli_fetch_all($conn->query($query), MYSQLI_ASSOC);
    return $result;
}