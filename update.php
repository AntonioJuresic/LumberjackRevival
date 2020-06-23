<?php
    include "connect.php";
    
    $id = $_POST['id'];

    $title = $_POST["title"];
    $about = $_POST["about"];
    $content = $_POST["content"];
    $category = $_POST["category"];

    if (isset($_POST["archive"])) {
        $archive = 1;
    } else {
        $archive = 0;
    }

    if ($_FILES["picture"]["name"] != "") {
        $picture = $_FILES["picture"]["name"];

        $target_dir = "media/images/" . $picture;
        move_uploaded_file($_FILES["picture"]["tmp_name"], $target_dir);

        $query = "UPDATE clanak SET slika = ? WHERE id=?";

        $stmt = mysqli_stmt_init($dbc);

        if (mysqli_stmt_prepare($stmt, $query)){
            mysqli_stmt_bind_param($stmt, 'si', $picture, $id);
            mysqli_stmt_execute($stmt);
        }
    }

    $query = "UPDATE clanak SET naslov = ?, sazetak = ?, tekst = ?, kategorija = ?, arhiva = ? WHERE id = ?";

    $stmt = mysqli_stmt_init($dbc);

    if (mysqli_stmt_prepare($stmt, $query)){
        mysqli_stmt_bind_param($stmt, 'sssssi', $title, $about, $content, $category, $archive, $id);
        mysqli_stmt_execute($stmt);
    }

    mysqli_close($dbc);
    
    header("Location:clanak.php?id=" . $id);
    exit();
?>