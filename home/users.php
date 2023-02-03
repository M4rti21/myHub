<?php
require_once "../src/header.php";
require_once '../src/scripts/getStuff.scr.php';
if (empty($_GET["page"]) || ($_GET["page"] < 1)) {
    $start = 1;
} else {
    $start = $_GET["page"];
}
$users = getUsers($start);
?>

<main class="flex-grow-1 d-flex justify-content-around pt-3 p-5">
    <div class="row w-100 d-flex justify-content-center">
        <div class="border rounded p-4 col-12 col-lg-6">
            <h3 class="text-center"><i class="bi bi-people"></i> Users</h3>
            <hr class="table-group-divider">
            <div id="userList" class="pe-3 d-flex flex-column justify-content-center">
                <nav class="mx-auto">
                    <ul class="pagination">
                        <?php
                        if ($start > 1) {
                            $before = $start - 1;
                            echo '<li class="page-item">
                                        <a class="page-link" href=users.php?page=' . $before . '>
                                            <i class="bi bi-caret-left"></i>
                                        </a>
                                        </li>';
                        }
                        ?>
                        <li class="page-item"><a class="page-link" href=""><?php echo $start; ?></a></li>
                        <?php
                        if (sizeof($users) > 9) {
                            $next = $start + 1;
                            echo '<li class="page-item">
                                        <a class="page-link" href=users.php?page=' . $next . '>
                                            <i class="bi bi-caret-right"></i>
                                        </a>
                                        </li>';
                        }
                        ?>
                    </ul>
                </nav>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Username</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    for ($i = 0; $i < sizeof($users); $i++) {
                        echo '<tr>
                                <th scope="row" class="col-1">' . $users[$i]["userId"] . '</th>
                                <td class="col-11"><a href="../profiles/userpage.php?usr=' . $users[$i]["userId"] . '">
                                        <img class="imgList rounded me-2" alt="" src="' . $users[$i]["userImage"] . '">' . $users[$i]["userName"] . '</td>
                                    </a>
                                </tr>';
                    }
                    ?>
                    </tbody>
                </table>
                <?php
                if (sizeof($users) < 10) {
                    echo '<h4 class="text-center">No more users found :(</h4>';
                }
                ?>
            </div>
        </div>
    </div>
</main>

<?php
require_once "../src/footer.php";
?>
