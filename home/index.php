<?php
require_once "../src/header.php";
$changes = scandir("../changelog", SCANDIR_SORT_DESCENDING);
?>

<main class="d-flex flex-column pt-3 px-4 flex-grow-1 overflow-y-scroll">
    <h2 class="text-center mb-3 col-12">Welcome :)</h2>
    <div class="row gap-3 mb-3">
        <div class="col-12 col-lg border rounded p-4 d-flex justify-content-center overflow-hidden">
            <img src="../src/img/elo.png" alt="" class="h-25 ratio-1x1 rounded">
        </div>
        <div class="col-12 col-lg-4 border rounded p-4 d-flex flex-column">
            <h3 class="text-center"><i class="bi bi-list-columns-reverse"></i> Changelog</h3>
            <hr class="table-group-divider">
            <div class="d-flex flex-column row-gap-2">
                <?php
                for ($i = 0; $i < sizeof($changes) - 2; $i++) {
                    echo '<div class="border rounded">
                        <h5 class="text-center mt-3">' . str_replace(".txt", "", $changes[$i]) . ' </h5><h6 class="fs-6 text-center">' . date("d/m/Y [h:iA]", filemtime("../changelog/"
                            . $changes[$i])) . '</h6>
                        <hr class="table-group-divider"><section class="p-3">'
                        . file_get_contents("../changelog/"
                            . $changes[$i]) . '</section></div>';
                }
                ?>
            </div>
        </div>
    </div>
</main>

<?php
require_once "../src/footer.php";
?>
