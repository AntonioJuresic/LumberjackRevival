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

    $id = NULL;
    $title = NULL;
    $about = NULL;
    $content = NULL;
    $category = NULL;
    $archive = NULL;

    if(isset($_GET["edit_id"])) {
        $edit_id = $_GET["edit_id"];
        $query = "SELECT * FROM clanak WHERE id=$edit_id";
        $result = mysqli_query($dbc, $query);

        while($row = mysqli_fetch_array($result)) {
            $id = $row['id'];
            $title = $row['naslov'];
            $about = $row['sazetak'];
            $content = $row['tekst'];
            $picture = $row['slika'];
            $category = $row['kategorija'];
            $archive = $row['arhiva'];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Lumberjack Revival</title>
    <meta name="description" content="Projekt iz PWA, napravio Antonio Jurešić 2020.">
    <meta name="author" content="Antonio Jurešić">
    <meta name="keywords" content="HTML, CSS, PHP, JavaScript">

    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="css/LumberjackStylesheet.css">
</head>

<body>
    <div class="page_wrapper">
        <?php include "header.php"; ?>

        <section>
            <form enctype="multipart/form-data" method="POST" action="skripta.php">
                <div class="form-item">
                    <label for="title">Article title: </label>
                    <div class="form-field">
                        <?php echo "<input type='text' name='title' id='title' value='" . $title . "' required>"; ?>
                    </div>
                    <span id="error_title" class="error"></span>
                </div>
                <br>

                <div class="form-item">
                    <label for="about">Short text (max 100 characters)</label>
                    <div class="form-field">
                        <?php echo "<textarea name='about' id='about' maxlength='100' required>". $about . "</textarea>"; ?>
                    </div>
                    <span id="error_about" class="error"></span>
                </div>
                <br>

                <div class="form-item">
                    <label for="content">Article text: </label>
                    <div class="form-field">
                        <?php echo "<textarea name='content' id='content' required>" . $content . "</textarea>"; ?>
                    </div>
                    <span id="error_content" class="error"></span>
                </div>
                <br>
                
                <div class="form-item">
                    <label for="picture">Article picture: </label>
                    <div class="form-field">
                        <?php
                            if(isset($_GET["edit_id"])) {
                                echo "<input name='picture' id='picture' type='file' accept='image/png,image/jpeg,image/gif'/>";
                                echo " <img src=' " . UPLPATH . $picture . "' style='width: 100%;'>";
                            } else {
                                echo "<input name='picture' id='picture' type='file' accept='image/png,image/jpeg,image/gif' required/>";
                            } 
                        ?>
                    </div>
                    <span id="error_picture" class="error"></span>
                </div>
                <br>
                
                <div class="form-item">
                    <label for="category">Category: </label>
                    <div class="form-field">
                        <select name="category" id="category" required>
                            <?php
                                if($category == "news") {
                                    echo "<option value='news' selected='selected'>News</option>";
                                    echo "<option value='lifestyle'>Lifestyle</option>";
                                } else if($category == "lifestyle") {
                                    echo "<option value='news'>News</option>";
                                    echo "<option value='lifestyle' selected='selected'>Lifestyle</option>";
                                } else {
                                    echo "<option value='' disabled selected>Chose category</option>";
                                    echo "<option value='news'>News</option>";
                                    echo "<option value='lifestyle'>Lifestyle</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <span id="error_category" class="error"></span>
                </div>
                <br>
                
                <div class="form-item">
                    <label for="archive">Spremiti u arhivu:
                        <div class="form-field">
                            <?php
                                if($archive == NULL || $archive == "0") {
                                    echo "<input type='checkbox' name='archive' id='archive'>";
                                } else if ($archive == "1") {
                                    echo "<input type='checkbox' name='archive' id='archive' checked>";
                                }
                            ?>
                        </div>
                    </label>
                </div>
                <br>

                <div class="form-item">
                    <?php echo "<input type='hidden' name='id' class='form-field-textual' value='" . $id . "'>";?>
                </div> 
                <br>   
                
                <div class="form-item">
                    <button type="reset" id="reset" name ="reset" value="reset">Reset</button>
                    <button type="submit" id="submit" name ="submit" value="submit">Submit</button>
                </div>
            </form>
        </section>
    </div>
    
    <?php include "footer.php"; ?>
</body>
</html>

<script>
        document.getElementById("submit").onclick = function(event) {
            var sendForm = true;
            
            //Title must be between 5 and 30 characters
            var fieldTitle = document.getElementById("title");
            var title = document.getElementById("title").value;
            
            if (title.length < 5 || title.length > 30) {
                sendForm = false;
                fieldTitle.style.border="0.25vw dashed red";
                document.getElementById("error_title").innerHTML = "Title must be between 5 and 30 characters<br>";
            } else {
                fieldTitle.style.border="0.25vw solid green";
                document.getElementById("error_title").innerHTML = "";
            }
            
            //About must be between 10 and 100 characters
            var fieldAbout = document.getElementById("about");
            var about = document.getElementById("about").value;

            if (about.length < 10 || about.length > 100) {
                sendForm = false;
                fieldAbout.style.border="0.25vw dashed red";
                document.getElementById("error_about").innerHTML = "About must be between 10 and 100 characters<br>";
            } else {
                fieldAbout.style.border="0.25vw solid green";
                document.getElementById("error_about").innerHTML = "";
            }

            //Content can't be empty
            var fieldContent = document.getElementById("content");
            var content = document.getElementById("content").value;
            
            if (content.length == 0) {
                sendForm = false;
                fieldContent.style.border="0.25vw dashed red";
                document.getElementById("error_content").innerHTML = "Content can't be empty!<br>";
            } else {
                fieldContent.style.border="0.25vw solid green";
                document.getElementById("error_content").innerHTML = "";
            }


            //Picture can't be empty
            var fieldPicture = document.getElementById("picture");
            var picture = document.getElementById("picture").value;
            if (picture.length == 0 && window.location.href.indexOf("edit_id") == false) {
                sendForm = false;
                fieldPicture.style.border="0.25vw dashed red";
                document.getElementById("error_picture").innerHTML = "Picture can't be empty, upload a picture!<br>";
            } else {
                fieldPicture.style.border="0.25vw solid green";
                document.getElementById("error_picture").innerHTML = "";
            }

            //Category can't be empty
            var fieldCategory = document.getElementById("category");
            if(document.getElementById("category").selectedIndex == 0) {
                sendForm = false;
                fieldCategory.style.border="0.25vw dashed red";
                document.getElementById("error_category").innerHTML="Category can't be empty!<br>";
            } else {
                fieldCategory.style.border="0.25vw solid green";
                document.getElementById("error_category").innerHTML="";
            }

            if (sendForm != true) {
                event.preventDefault();
            }
        }
</script>