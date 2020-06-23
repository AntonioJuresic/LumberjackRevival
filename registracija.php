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

        <?php
            if (isset($_POST["submit"])) {    
                include "connect.php";
            
                $name = $_POST["name"];
                $surname = $_POST["surname"];
                $username = $_POST["username"];
                $hashed_password = password_hash($_POST["password"], CRYPT_BLOWFISH);
                $hashed_repeated_password = password_hash($_POST["repeatedPassword"], CRYPT_BLOWFISH);
                $inviteCode = $_POST["inviteCode"];
                $level = 0;

                if ($inviteCode == "12345") {
                    $level = 1;
                    echo "Razina 1";
                } else {
                    echo "Razina 0";
                }

                $canRegisterNewUser = true;

                $query = "SELECT korisnickoIme FROM korisnik";
                $result = mysqli_query($dbc, $query) or
                    die("Greška prilikom SQL upita");

                while($row = mysqli_fetch_array($result)) {
                    if ($row["korisnickoIme"] == $username) $canRegisterNewUser = false;
                }

                if ($canRegisterNewUser == false) {
                    echo "Username already in use!";
                } else {
                    if ($_POST["password"] != $_POST["repeatedPassword"]) $canRegisterNewUser = false; 
                    if ($canRegisterNewUser == false) echo "Passwords don't match!";
                }

                if ($canRegisterNewUser == true) {
                    $query = "INSERT INTO korisnik (ime, prezime, korisnickoIme, lozinka, razina) VALUES (?, ?, ?, ?, ?)";

                    $stmt = mysqli_stmt_init($dbc);

                    if (mysqli_stmt_prepare($stmt, $query)){
                        mysqli_stmt_bind_param($stmt, 'ssssi', $name, $surname, $username, $hashed_password, $level);
                        mysqli_stmt_execute($stmt);
                    }

                    header("Location:prijava.php?success=1");
                    exit();
                }
                
                mysqli_close($dbc);  
            }
        ?>

        <form method="post" action="registracija.php">
            <label for="name">Name:</label>
            <br>
            <input name="name" id="name" type="text"/>
            <span id="error_name" class="error"></span>
            <br>

            <label for="surname">Surname:</label>
            <br>
            <input name="surname" id="surname" type="text"/>
            <span id="error_surname" class="error"></span>
            <br>

            <label for="username">User name:</label>
            <br>
            <input name="username" id="username" type="text"/>
            <span id="error_username" class="error"></span>
            <br>

            <label for="password">Lozinka:</label>
            <br>
            <input name="password" id="password" type="password"/>
            <span id="error_password" class="error"></span>
            <br>

            <label for="repeatedPassword">Repeated password:</label>
            <br>
            <input name="repeatedPassword" id="repeatedPassword" type="password"/>
            <span id="error_repeatedPassword" class="error"></span>
            <br>

            <label for="inviteCode">Invite code:</label>
            <br>
            <input name="inviteCode" type="password"/>
            <br>

            <br>
            <button type="submit" id="submit" name ="submit" value="submit">Register</button>
        </form>  
    </div>
    
    <?php include "footer.php"; ?>
</body>

</html>

<script>
    document.getElementById("submit").onclick = function(event) {
        var sendForm = true;
        
        //Name can't be empty
        var fieldName = document.getElementById("name");
        var name = document.getElementById("name").value;
        
        if (name.length == 0) {
            sendForm = false;
            fieldName.style.border="0.25vw dashed red";
            document.getElementById("error_name").innerHTML = "<br>Name can't be empty!";
        } else {
            fieldName.style.border="0.25vw solid green";
            document.getElementById("error_name").innerHTML = "";
        }

        //Surname can't be empty
        var fieldSurname = document.getElementById("surname");
        var surname = document.getElementById("surname").value;
        
        if (surname.length == 0) {
            sendForm = false;
            fieldSurname.style.border="0.25vw dashed red";
            document.getElementById("error_surname").innerHTML = "<br>Surname can't be empty!";
        } else {
            fieldSurname.style.border="0.25vw solid green";
            document.getElementById("error_surname").innerHTML = "";
        }

        //username can't be empty
        var fieldusername = document.getElementById("username");
        var username = document.getElementById("username").value;
        
        if (username.length == 0) {
            sendForm = false;
            fieldusername.style.border="0.25vw dashed red";
            document.getElementById("error_username").innerHTML = "<br>username can't be empty!";
        } else {
            fieldusername.style.border="0.25vw solid green";
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

        //RepeatedPassword can't be empty
        var fieldRepeatedPassword = document.getElementById("repeatedPassword");
        var repeatedPassword = document.getElementById("repeatedPassword").value;

        if (repeatedPassword.length == 0) {
            sendForm = false;
            fieldRepeatedPassword.style.border="0.25vw dashed red";
            document.getElementById("error_repeatedPassword").innerHTML = "<br>Repeated password can't be empty!";
        } else {
            fieldRepeatedPassword.style.border="0.25vw solid green";
            document.getElementById("error_repeatedPassword").innerHTML = "";
        }

        if (password != repeatedPassword) {
            sendForm = false;
            fieldPassword.style.border="0.25vw dashed red";
            document.getElementById("error_password").innerHTML = "<br>Passwords don't match!";
        }

        if (sendForm != true) {
            event.preventDefault();
        }
    }
</script>