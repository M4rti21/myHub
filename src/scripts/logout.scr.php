<?php
session_start();
session_unset();
session_destroy();
header("Location: ".$_GET["CurPageURL"]);
exit();