<?php
    session_start();

    include "connect.php";
    define("UPLPATH", "media/images/");

    $category = $_GET["id"];

    $query = "SELECT * FROM clanak WHERE kategorija LIKE '" . $category . "' AND arhiva=0 ORDER BY id DESC";
    $result = mysqli_query($dbc, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <?php
        echo "<title>" . $category . " | Lumberjack Revival</title>";
    ?>
    <meta name="description" content="Projekt iz PWA">
    <meta name="keywords" content="HTML, CSS, PHP">
    <meta name="author" content="Antonio Jurešić">

    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="css/LumberjackStylesheet.css">
</head>

<body>
    <div class="page_wrapper">
        <?php include "header.php"; ?>

        <section>
            <div class="left-part">
                <hr>
                <?php echo "<h2>" . $category . "</h2>"; ?>
            </div>

            <div class="right-part">
                <?php
                    while($row = mysqli_fetch_array($result)) {
                        echo "<article>";

                        echo "<img src='" . UPLPATH . $row['slika'] . "'>"; 

                        echo "<h3>";
                        echo "<a href='clanak.php?id=".$row['id']."'>";
                        echo $row['naslov'];
                        echo "</a></h3>";

                        echo "<p>" . $row['sazetak'] . "</p>";

                        echo "</article>";
                    }
                ?>
            </div>
        </section>
    </div>
    
    <?php include "footer.php"; ?>
</body>

</html>