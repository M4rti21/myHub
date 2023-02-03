<?php
session_start();
$url = isset($_SERVER['HTTPS']) &&
$_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
$url .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
if (!empty($_GET['mode'])) {
    $_SESSION['mode'] = $_GET['mode'];
}
if (empty($_SESSION['mode'])) {
    $mode = "dark";
    $otherMode = "light";
} else {
    $mode = $_SESSION['mode'];
    switch ($mode) {
        case "light":
            $otherMode = "dark";
            break;
        case "dark":
            $otherMode = "light";
            break;
        default:
            $otherMode = "light";
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="<?php echo $mode;?>" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>myHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
            crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/766f640de5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../src/css/style.css">
    <link rel="icon" type="image/x-icon" href="../src/img/ico.png">
</head>
<body class="d-flex flex-column vh-100 overflow-hidden">
<header>
    <nav class="navbar navbar-expand-lg bg-black">
        <div class="container-fluid">
            <a class="navbar-brand text-light align-text-top" href="../home/index.php">
                <img src="../src/img/ico.png" alt="Logo" width="24" height="24" class="d-inline-block align-text-top">
                myHub</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-light" aria-current="page" href="../home/index.php"><i class="bi bi-house"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="../home/users.php"><i class="bi bi-people"></i> Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="../home/chat.php"><i class="bi bi-chat-left-dots"></i> Chat</a>
                    </li>
                </ul>
                <div class="d-flex flex-row gap-2">
                    <?php
                    if (isset($_SESSION["userName"])) {
                        echo '
                            <div class="dropdown">
                                <a class="btn btn-dark d-flex flex-row gap-2 align-items-center overflow-hidden p-0 ps-2" id="usr" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    ' . $_SESSION["userName"] . '<img class="profile_picture" alt="" src="' . $_SESSION["userImage"] . '">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-lg-end">
                                    <li><a class="dropdown-item" href="../profiles/userpage.php?usr=' . $_SESSION["userId"] . '"><i class="bi bi-person-square"></i> Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="../src/scripts/logout.scr.php?CurPageURL=' . $url . '"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                                </ul>
                            </div>
                            ';
                    } else {
                        echo '
                            <a href="../home/signup.php"><button class="btn btn-primary"><i class="bi bi-person-plus"></i> Register</button></a>
                            <a href="../home/login.php"><button class="btn btn-success"><i class="bi bi-person"></i> Login</button></a>
                            ';
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>
</header>