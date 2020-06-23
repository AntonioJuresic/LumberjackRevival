<?php
    include "connect.php";

    $id;

    $title = $_POST["title"];
    $about = $_POST["about"];
    $content = $_POST["content"];
    $picture = $_FILES["picture"]["name"];
    $category = $_POST["category"];

    if(isset($_POST["archive"])) {
        $archive = 1;
    } else {
        $archive = 0;
    }
    
    $date = date("d.m.Y.");

    $target_dir = "media/images/" . $picture;
    move_uploaded_file($_FILES["picture"]["tmp_name"], $target_dir);

    $query = "INSERT INTO clanak (datum, naslov, sazetak, tekst, slika, kategorija, arhiva) VALUES (?, ?, ?, ?, ?, ?, ?);";
    
    $stmt = mysqli_stmt_init($dbc);

    if (mysqli_stmt_prepare($stmt, $query)){
        mysqli_stmt_bind_param($stmt, 'ssssssi', $date, $title, $about, $content, $picture, $category, $archive);
        mysqli_stmt_execute($stmt);
    }








    $sql = "SELECT id FROM clanak WHERE naslov = ?;";

    $stmt = mysqli_stmt_init($dbc);

    if (mysqli_stmt_prepare($stmt, $sql)){
        mysqli_stmt_bind_param($stmt,'s', $title);

        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
    }

    mysqli_stmt_bind_result($stmt, $id);
    mysqli_stmt_fetch($stmt);

    mysqli_close($dbc);
    
    header("Location:clanak.php?id=" . $id);
    exit();
?>