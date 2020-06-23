<header>
    <h1>Lumberjack Revival</h1>

    <nav>
        <hr>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="kategorija.php?id=NEWS">News</a></li>
            <li><a href="kategorija.php?id=LIFESTYLE">Lifestyle</a></li>

            <?php 
                if (isset($_SESSION['level'])) {
                    if ($_SESSION['level'] == 1) {
                        echo "<ul class='dropdown_wide'>";
                            echo "<p class='nav_username'>" . $_SESSION['username'] . "<br>";
                            echo "<li><a href='myprofile.php'>My profile</a></li>";
                            echo "<li><a href='administracija.php'>Administration</a></li>";
                            echo "<li><a href='index.php?log_out=1'>Log out</a></li>";
                        echo "</ul>";

                        echo "<li class='dropdown_narrow'><a href='myprofile.php'>My profile</a></li>";
                        echo "<li class='dropdown_narrow'><a href='administracija.php'>Administration</a></li>";
                        echo "<li class='dropdown_narrow'><a href='index.php?log_out=1'>Log out</a></li>";
                    } else if ($_SESSION['level'] == 0) {
                        echo "<ul class='dropdown_wide'>";
                            echo "<p class='nav_username'>" . $_SESSION['username'] . "<br>";
                            echo "<li><a href='myprofile.php'>My profile</a></li>";
                            echo "<li><a href='index.php?log_out=1'>Log out</a></li>";
                        echo "</ul>";

                        echo "<li class='dropdown_narrow'><a href='myprofile.php'>My profile</a></li>";
                        echo "<li class='dropdown_narrow'><a href='index.php?log_out=1'>Log out</a></li>";
                    }
                } else {
                    echo " <li><a href='prijava.php'>Login</a></li>";
                }
            ?>
        </ul>
        <hr>
    </nav>
</header>