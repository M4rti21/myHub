<?php
require_once "../src/header.php";
require_once '../src/scripts/dbh.scr.php';
require_once '../src/scripts/getStuff.scr.php';
?>
    <main>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6 p-4">
                <h1 class="text-center fs-3 mb-3" id="registerModalToggleLabel"><i class="bi bi-person-plus"></i>
                    Register an
                    account
                </h1>
                <form action="../src/scripts/signup.scr.php" method="post" class="mb-3">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="username_input">Username</label>
                        <input class="form-control" id="username_input" maxlength="25" minlength="3"
                               name="username"
                               placeholder="Only letters, numbers and _ no spaces" type="text" required>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="email_input">Email</label>
                        <input class="form-control" id="email_input" name="email"
                               placeholder="example@example.com"
                               type="email" required>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="password_input">Password</label>
                        <input class="form-control" id="password_input"
                               name="password" placeholder="8 characters minimum" type="password" required>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="password_repeat_input">Repeat password</label>
                        <input class="form-control" id="password_repeat_input"
                               name="password_repeat" placeholder="Repeat password" type="password" required>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="birthday_input">Birthday</label>
                        <input class="form-control" id="birthday_input" name="birthday" type="date" required>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="gender">Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="">Choose...</option>
                            <?php
                                $genders = getThing('genders', $conn);
                                for ($i = 0; $i < sizeof($genders); $i++) {
                                    echo '<option value="'.$genders[$i]["code"].'">'.$genders[$i]["gender"].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="d-flex flex-row justify-content-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" id="flexCheckDefault" type="checkbox" value=""
                                   required>
                            <label class="form-check-label" for="flexCheckDefault">
                                Accept Terms and Conditions
                            </label>
                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-center">
                        <input class="btn btn-primary" id="submit_button" type="submit" value="Register"
                               name="signup_submit">
                    </div>
                    <section id="user_registered"></section>
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
                        case "invalidUsername":
                            echo '
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Invalid username characters!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                ';
                            break;
                        case "invalidEmail":
                            echo '
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Invalid email!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                ';
                            break;
                        case "passwordsDontMatch":
                            echo '
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Passwords do not match!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                ';
                            break;
                        case "usernameTaken":
                            echo '
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Username already taken :(
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                ';
                            break;
                        case "emailTaken":
                            echo '
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Email already in use! You might want to <a class="link-primary" href="login.php">Login instead!</a>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                ';
                            break;
                        case "stmtFailed":
                            echo '
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Something went wrong, please try again!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                ';
                            break;
                        case "none":
                            echo '
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle-fill"></i> Successfully signed up!
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
require_once "../src/footer.php";
?>