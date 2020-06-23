<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST['id'] == NULL) {
            include "insert.php";
        } else if($_POST['id'] != NULL) {
            include "update.php";
        }
    }

    header("Location:index.php");
    exit();
?>