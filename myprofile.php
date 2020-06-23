<?php
    session_start();

    if (isset($_SESSION['level']) == false) {
        header("Location:prijava.php");
        exit();
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

        <section>
            <div class="my_profile" style="width: 95%; margin: 0 auto;">
                <h2>My profile:</h2>
                <br>

                <?php       
                    echo "<p>Username: " . $_SESSION['username'] . "</p><br>";
                    echo "<p>First name: " . $_SESSION['name'] . "</p><br>";
                    echo "<p>Last name: " .  $_SESSION['surname'] . "</p><br>";
                    echo "<p>Level: " . $_SESSION['level'] . "</p><br>";

                    if ($_SESSION['level'] == 1) {
                        echo "<p>You are an administrator</p>";
                    } else if ($_SESSION['level'] == 0) {
                        echo "<p>You are a regular user</p>";
                    }
                ?>
            </div>
        </section>
    </div>
    
    <?php include "footer.php"; ?>
</body>

</html>