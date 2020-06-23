<?php
    session_start();

    if (isset($_SESSION['level']) == false) {
        header("Location:prijava.php");
        exit();
    }

    if ($_SESSION['level'] == 0) {
        header("Location:index.php");
        exit();
    }

    include "connect.php";
    define("UPLPATH", "media/images/");

    if(isset($_GET["delete_id"])) {
        $delete_id = $_GET["delete_id"];
        $query = "DELETE FROM clanak WHERE id=$delete_id";
        $result = mysqli_query($dbc, $query) or
        die("Error connecting to MySQL server.".mysqli_error());
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Lumberjack Revival</title>
    <meta name="description" content="Projekt iz PWA">
    <meta name="keywords" content="HTML, CSS, PHP">
    <meta name="author" content="Antonio Jurešić">

    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="css/LumberjackStylesheet.css">
</head>

<body>
    <div class="page_wrapper">
        <?php include "header.php"; ?>

        <div class="administration" style="width: 95%; margin: 0 auto;">    
            <a href="unos.php">Add new article</a>

            <p>Edit or delete articles:</p>

            <?php
                $query = "SELECT * FROM clanak ORDER BY id DESC;";
                $result = mysqli_query($dbc, $query);
                while($row = mysqli_fetch_array($result)) {
                    echo "<article>";

                    echo "<img src='" . UPLPATH . $row['slika'] . "'>"; 

                    echo "<div class=article_name>";
                        echo "<h3>";
                        echo "<a href='clanak.php?id= " . $row['id'] . "'>";
                        echo $row['naslov'];
                        echo "</a></h3>";
                    echo "</div>";

                    echo "<div class=article_edit_delete>";
                        echo "<a href='unos.php?edit_id=" . $row['id'] . "'>" . "EDIT " . "</a><br>";
                        echo "<a href='administracija.php?delete_id=" . $row['id'] . "'>" . " DELETE" . "</a>";
                    echo "</div>";

                    echo "</article>";
                }
            ?>
        </div>
    </div>
    
    <?php include "footer.php"; ?>
</body>

</html>