<?php
require_once "../src/header.php";
if (empty($_GET["usr"])) {
    $pageUserId = 0;
} else {
    $pageUserId = $_GET["usr"];
}
require_once '../src/scripts/dbh.scr.php';
require_once '../src/scripts/seeProfile.scr.php';
require_once '../src/scripts/getStuff.scr.php';

$userData = searchUser($pageUserId, $conn);
$pageLinks = searchUserSocials($pageUserId, $conn);
$pageUserName = $userData["userName"];
$pageUserPfp = $userData["userImage"];
$pageUserBanner = $userData["userBanner"];
$pageUserDesc = $userData["userDescription"];
?>

<main class="overflow-x-hidden flex-grow-1">
    <div class="row justify-content-center h-100">
        <div class="col-12 col-lg-11 p-3 h-100">
            <div class="d-flex flex-row align-items-center gap-4 justify-content-center">
                <h1 class="text-center fs-3 mb-3" id="registerModalToggleLabel"><i class="bi bi-person-square"></i>
                    <?php
                    if ($pageUserId == $_SESSION["userId"]) {
                        echo 'Welcome to your profile, ' . $_SESSION["userName"];
                    } else {
                        echo "Welcome to " . $pageUserName . "'s profile!";
                    }
                    echo '</h1>';
                    if ($pageUserId == $_SESSION["userId"]) {
                        echo '<a href="edit.php" id="ico"><h4 class="pb-2"><i class="bi bi-pencil-square"></i></h4></a>';
                    }
                    ?>
            </div>
            <div class="d-flex flex-column row-gap-3">
                <div class="row d-flex flex-row">
                    <div class="col-lg-2 col-12">
                        <div class="position-relative">
                            <?php
                            if ($pageUserId == $_SESSION["userId"]) {
                                echo '
                            <form class="uploadButton" action="../src/scripts/upload.scr.php" method="post" enctype="multipart/form-data">
                                <label for="filePfp" class="btn btn-outline-light"><i class="bi bi-pencil-square"></i></label>
                                <input type="file" name="file" id="filePfp" class="imgFormUpload">
                            </form>';}
                            ?>
                            <img src="<?php echo $pageUserPfp; ?>" alt="" class="rounded ratio border"
                                 id="profile-pfp"/>
                        </div>
                    </div>
                    <div class="col-lg col-12 row-gap-3 d-flex flex-column">
                        <div class="position-relative flex-grow-1">
                            <?php
                            if ($pageUserId == $_SESSION["userId"]) {
                                echo '
                            <form class="uploadButton" action="../src/scripts/uploadBanner.scr.php" method="post" enctype="multipart/form-data">
                                <label for="fileBanner" class="btn btn-outline-light"><i class="bi bi-pencil-square"></i></label>
                                <input type="file" name="file" id="fileBanner" class="imgFormUpload">
                            </form>';}
                            ?>
                            <img src="<?php echo $pageUserBanner; ?>" alt="" class="rounded border" id="banner"/>
                        </div>
                    </div>
                </div>
                <div class="row d-flex flex-row">
                    <div class="col-lg-2 col-12">
                        <div class="border rounded p-3">
                            <h5 class="text-center"><?php echo $pageUserName; ?></h5>
                            <hr class="table-group-divider">
                            <div class="d-flex flex-row justify-content-end mb-3 gap-2 position-relative">
                                <h4 class="w-100" id="socialsSection">Socials:</h4>
                                <?php
                                if ($pageUserId == $_SESSION["userId"]) {
                                    echo '  <button class="btn btn-outline-light uploadButton3" id="showEdit"><i class="bi bi-pencil-square"></i></button>
                                            <a href="userpage.php?usr=' . $pageUserId . '"><button class="btn btn-outline-success" id="showClose"><i class="bi bi-check-square"></i></button></a>';
                                }
                                ?>
                            </div>
                            <div class="gap-2 row-gap-2 d-flex flex-row flex-wrap">
                                <?php

                                if ($pageUserId == $_SESSION["userId"]) {
                                    $getSocialsLeft = getSocialsLeft($conn);
                                    echo '<div id="addForm" class="w-100"><form method="POST" action="../src/scripts/uploadSocials.scr.php" class="border rounded d-flex flex-column row-gap-2 text-light p-2">
                                            <label for="socI"></label>
                                            <select class="form-select" id="socI" name="socialId" required>';
                                    for ($i = 0; $i < sizeof($getSocialsLeft); $i++) {
                                        echo '<option id="newSocialsDrop" value="' . $getSocialsLeft[$i]["socialId"] . '">' . $getSocialsLeft[$i]["socialName"] . '</option>';
                                    }

                                    echo '</select>
                                            <label for="socL"></label>
                                            <input required type="text" name="usrSocialName" class="form-control" id="socL">
                                            <input type="submit" name="soc_submit" value="Add" class="btn btn-outline-primary"/>
                                        </form></div>';
                                }
                                for ($k = 0; $k < sizeof($pageLinks); $k++) {
                                    echo '<div class="social_box"><div id="social_' . $pageLinks[$k]["socialId"] . '" class="rounded d-flex flex-row gap-2 text-light p-2" style="background-color: ' . $pageLinks[$k]["socialColor"] . ';"><a href="';
                                    if (empty($pageLinks[$k]["profUrl"])) {
                                        echo '#" role="link" aria-disabled="true" class="d-flex flex-row gap-2 text-light disabledLink"';
                                    } else {
                                        echo $pageLinks[$k]["profUrl"] . $pageLinks[$k]["socialUsrName"] . '" class="d-flex flex-row gap-2 text-light"';
                                    }
                                    echo 'target="_blank">' . $pageLinks[$k]["socialIcon"] . $pageLinks[$k]["socialUsrName"];
                                    if ($pageUserId == $_SESSION["userId"]) {
                                        echo '</a><form action="../src/scripts/removeSocials.scr.php" method="post" class="close_ico"><input style="display: none" name="socIdRem" value="' . $pageLinks[$k]["socialId"] . '"/><input class="btn btn-close" type="submit" name="updateSocials_submit" value=""></form></div></div>';
                                    } else {
                                        echo '</a></div></div>';
                                    }
                                }

                                if ($pageUserId == $_SESSION["userId"]) {
                                    $getSocials = getSocials($conn);
                                    echo '
                                <script src="../src/js/show_Close.js" defer></script>
                                ';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg col-12 row-gap-3 d-flex flex-column">
                        <div class="border rounded p-3 position-relative">
                            <h5 class="text-center"><i class="bi bi-card-text"></i> About me</h5>
                            <?php
                        //    if ($pageUserId == $_SESSION["userId"]) {
                        //        echo '
                        //    <form class="uploadButton2" action="../src/scripts/uploadBanner.scr.php" method="post" enctype="multipart/form-data">
                        //        <label for="fileBanner" class="btn btn-outline-light"><i class="bi bi-pencil-square"></i></label>
                        //        <input type="file" name="file" id="fileBanner" class="imgFormUpload">
                        //    </form>';}
                            ?>
                            <hr class="table-group-divider">
                            <?php
                            $desc = "../user_desc/" . $pageUserId . "-desc.txt";
                            if (strlen(file_get_contents($desc)) < 1) {
                                echo 'This user has not written any description yet...';
                            } else {
                                echo file_get_contents($desc);
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-2 h-100">
                    what is this?
                </div>
            </div>
        </div>
    </div>
</main>
<script src="../src/js/uploadForms.js" defer></script>

<?php
if ($_GET["edit"] == "1") {
    echo '<script src="../src/js/ifEdit.js" defer></script>';
}
require_once "../src/footer.php";
?>
