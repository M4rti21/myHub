<?php
require "../src/header.php";
?>
    <main>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6 p-4">
                <h1 class="text-center fs-3 mb-3" id="registerModalToggleLabel"><i class="bi bi-person"></i>
                    Login
                </h1>
                <form action="../src/scripts/login.scr.php" method="post" class="mb-3">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="username_input">Username/Email</label>
                        <input class="form-control" id="username_input" maxlength="25" minlength="3"
                               name="username"
                               placeholder="Username or Email" type="text" required>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="password_input">Password</label>
                        <input class="form-control" id="password_input"
                               name="password" placeholder="('⚆_⚆)" type="password" required>
                    </div>
                    <div class="d-flex flex-row justify-content-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" id="flexCheckDefault" type="checkbox" name="remember" value="">
                            <label class="form-check-label" for="flexCheckDefault">
                                Remember me (does not work yet)
                            </label>
                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-center">
                        <input class="btn btn-primary" id="submit_button" type="submit" value="Login"
                               name="login_submit">
                    </div>
                </form>
                <?php
                if (isset($_GET["error"])) {
                    switch ($_GET["error"]) {
                        case "emptyInput":
                            echo '
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill"></i> All fields must be filled!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                ';
                            break;
                        case "wrongLogin":
                            echo '
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-x-circle-fill"></i> Incorrect username or password
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                ';
                            break;
                        default:
                    }
                }
                ?>
            </div>
        </div>
    </main>

<?php
require "../footer.php";
?>