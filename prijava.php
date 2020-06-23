<?php
    include "connect.php";
    
    session_start();

    if (isset($_SESSION['level'])) {
        header("Location:index.php");
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

        <form method="post" action="prijava.php">
            <p>Don't have an account? <a href="registracija.php">Register here!</a></p>
            <br>

            <?php 
                if(isset($_GET["success"]) && $_GET["success"] == 1) {
                    echo "<p>Profile made successfully!</p>";
                }
            ?>

            <br>

            <label for="username">User name:</label>
            <br>
            <input name="username" id="username" type="text"/>
            <span id="error_username" class="error"></span>
            <br>

            <label for="password">Password:</label>
            <br>
            <input name="password" id="password" type="password"/>
            <span id="error_password" class="error"></span>
            <br>
            <br>

            <br>
            <button type="submit" id="submit" name ="submit" value="submit">Login</button>
        </form>
        
        <?php
            if (isset($_POST["submit"])) {   
                $username = $_POST["username"];
                $password = $_POST["password"];
            
                $doesUserExist = false;
            
                $query = "SELECT korisnickoIme FROM korisnik";
            
                $result = mysqli_query($dbc, $query) or
                    die("Greška prilikom SQL upita");
            
                while ($row = mysqli_fetch_array($result)) {
                    if ($row["korisnickoIme"] == $username) {
                        $doesUserExist = true;
                    }
                }
            
                if ($doesUserExist == true) {
                    $sql = "SELECT * FROM korisnik WHERE korisnickoIme = ?;";

                    $stmt = mysqli_stmt_init($dbc);

                    if (mysqli_stmt_prepare($stmt, $sql)){
                        mysqli_stmt_bind_param($stmt,'s',$username);

                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                    }

                    mysqli_stmt_bind_result($stmt, $id, $name, $surname, $username, $passwordSQL, $razina);
                    mysqli_stmt_fetch($stmt);
            
                    if (password_verify($password , $passwordSQL) == true) {
                        session_start();
                        
                        $_SESSION['id'] = $id;
                        $_SESSION['name'] = $name;
                        $_SESSION['surname'] = $surname;
                        $_SESSION['username'] = $username;
                        $_SESSION['level'] = $razina;
                            
                        header("Location:index.php");
                        exit();
                    } else {
                        echo "<p style='padding: 2vw;'>You entered a wrong username or pasword!</p>";
                    }
                } else {
                    echo "<p style='padding: 2vw;'>You entered a wrong username or pasword!</p>";
                }
            }
        ?>
    </div>
    
    <?php include "footer.php"; ?>
</body>

</html>

<script>
    document.getElementById("submit").onclick = function(event) {
        var sendForm = true;
        
        //Username can't be empty
        var fieldUsername = document.getElementById("username");
        var username = document.getElementById("username").value;
        
        if (username.length == 0) {
            sendForm = false;
            fieldUsername.style.border="0.25vw dashed red";
            document.getElementById("error_username").innerHTML = "<br>Username can't be empty!";
        } else {
            fieldUsername.style.border="0.25vw solid green";
            document.getElementById("error_username").innerHTML = "";
        }

        //Password can't be empty
        var fieldPassword = document.getElementById("password");
        var password = document.getElementById("password").value;
        
        if (password.length == 0) {
            sendForm = false;
            fieldPassword.style.border="0.25vw dashed red";
            document.getElementById("error_password").innerHTML = "<br>Password can't be empty!";
        } else {
            fieldPassword.style.border="0.25vw solid green";
            document.getElementById("error_password").innerHTML = "";
        }

        if (sendForm != true) {
            event.preventDefault();
        }
    }
</script>