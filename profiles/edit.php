<?php
require_once '../src/header.php';
if (empty($_SESSION["userId"])) {
    header("Location: userpage.php");
    exit();
}
?>
<main class="overflow-y-scroll overflow-x-hidden">
    <div class="row justify-content-center row-gap-2">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="col-12 p-4 row">
                    <div class="col-12 col-lg-8">
                        <form action="../src/scripts/upload.scr.php" method="post" class="mb-3" enctype="multipart/form-data">
                            <label for="basic-url" class="form-label">Change profile picture:</label>
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" name="file">
                            </div>
                            <input class="btn btn-primary" type="submit" name="upload_submit" value="Upload">
                        </form>
                        <?php
                        require_once '../src/errors/profilePicture.errors.php';
                        ?>
                    </div>
                    <div class="col-12 col-lg-4">
                        <h2>Current profile picture:</h2>
                        <img src="<?php echo $_SESSION["userImage"]; ?>" class="rounded ratio ratio-1x1" alt="">
                    </div>
                </div>
                <div class="col-12 p-4 row">
                    <div class="col-12 col-lg-8">
                        <form action="../src/scripts/uploadBanner.scr.php" method="post" class="mb-3" enctype="multipart/form-data">
                            <label for="basic-url" class="form-label">Change Banner:</label>
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" name="file">
                            </div>
                            <input class="btn btn-primary" type="submit" name="uploadB_submit" value="Upload">
                        </form>
                        <?php
                        require_once '../src/errors/profileBanner.errors.php';
                        ?>
                    </div>
                    <div class="col-12 col-lg-4">
                        <h2>Current banner:</h2>
                        <img src="<?php echo $_SESSION["userBanner"]; ?>" class="rounded ratio ratio-1x1" alt="">
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <form class="my-4 h-100" action="../src/scripts/uploadDesc.scr.php" method="post">
                    <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                        <div class="d-flex flex-column align-content-center">
                            <label for="descEdit" class="form-label">Tell others about
                                yourself! <em>(4000 characters max)</em></label>
                            <p>Characters left: <span id="chars_left"></span></p>
                        </div>
                        <input class="btn btn-primary" type="submit" name="uploadD_submit" value="Upload">
                    </div>
                    <textarea class="form-control h-100" rows="10" id="descEdit" placeholder="Hello! My name is..." name="descriptionBox"><?php ?></textarea>
                </form>
                <?php
                echo '<script src="../src/js/app.js"></script>';
                require_once '../src/errors/profilePicture.errors.php';
                ?>
            </div>
        </div>
    </div>
</main>
<?php
require '../footer.php';
?>