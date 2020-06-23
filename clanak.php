<?php
    session_start();

    include "connect.php";

    $id = $_GET["id"];

    $query = "SELECT * FROM clanak WHERE id =" . $id . ";";
    $result = mysqli_query($dbc, $query);

    define("UPLPATH", "media/images/");
    while($row = mysqli_fetch_array($result)) { 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php
        echo "<title>" . $row['naslov'] . "</title>";
        echo "<meta name='description' content='" . $row['sazetak'] . "'>";
    ?>

    <meta name="author" content="Antonio Jurešić">
    <meta name="keywords" content="HTML, CSS, PHP, JavaScript">

    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="css/LumberjackStylesheet.css">
</head>

<body>
    <div class="page_wrapper">
        <?php include "header.php"; ?>

        <section>
            <div class="one_article">
                <div style="width: 95%; margin: 0 auto;">
                    <h3 class="category">
                        <?php echo $row['kategorija']; ?>
                    </h3>

                    <h2 class="title">
                        <?php echo $row['naslov'] ?>
                    </h2>

                    <p class="date">
                        <?php echo $row['datum']; ?>
                    </p>
                </div>
                
                <?php echo "<img src='" . UPLPATH . $row['slika'] . "'>"; ?>

                <div style="width: 95%; margin: 0 auto;">
                    <h3 class="short_text">
                        <?php echo $row['sazetak']; ?>
                    </h3>

                    <p class="content">
                        <?php echo $row['tekst']; ?>
                    </p>

                    <?php
                        $url_title = str_replace(' ', '%20', $row['naslov']);

                        echo "<a href='https://www.reddit.com/submit?url=https%3A%2F%2Fwww.lumberjackrevival.ueuo.com%2Fclanak.php%3Fid%3D" . $id . "&title=" . $url_title . "' target='_blank'>";
                            echo "<img class='social_media_button'  id='reddit_social_media_button' src='css/reddit.png' alt='Submit to Reddt'>";
                        echo "</a>";
                        echo "<a href='https://twitter.com/intent/tweet?text=" . $url_title . "%0A%0Awww.lumberjackrevival.ueuo.com%2Fclanak.php%3Fid%3D" . $id . "' target='_blank'>";
                            echo "<img class='social_media_button'  id='twitter_social_media_button' src='css/twitter.png' alt='Tweet to Twitter' >";
                        echo "</a>";

                        echo "<a onClick=\"window.open('https://www.facebook.com/sharer/sharer.php?u=lumberjackrevival.ueuo.com%2Fclanak.php%3Fid%3D" . $id . "','sharer','toolbar=0,status=0,height=325');\" href=\"javascript: void(0)\">";
                            echo "<img class='social_media_button'  id='facebook_social_media_button' src='css/facebook.png' alt='Share on Facebook'>";
                        echo "</a>";
                        }       
                    ?>
                </div>
            </div>
        </section>
    </div>
    
    <?php include "footer.php"; ?>
</body>

</html>