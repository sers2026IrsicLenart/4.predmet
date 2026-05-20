<?php
    session_start();
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "predmet4";

    $conn = mysqli_connect($hostname, $username, $password, $database);

    if (!$conn) 
        {
        die("Napaka pri povezavi z bazo: " . mysqli_connect_error());
        }

    $sql1 = "SELECT a.*, i.izvajalec_ime FROM albumi a JOIN izvajalci i ON a.izvajalec_id = i.izvajalec_id ORDER BY zaloga DESC;";
    $sql2 = "SELECT * FROM albumi a JOIN izvajalci i ON a.izvajalec_id = i.izvajalec_id WHERE zanr = 'Prog Rock' ORDER BY cena desc LIMIT 5;";
    $result = mysqli_query($conn, $sql1);
    $num_r = mysqli_num_rows($result);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <?php
    include('search.php')
    ?>
    <?php
    include('navigacija.php')
    ?>
    <main>
        <div class="albumi-napis">
            <div>Best Selling Records</div>
        </div>
        <div class="albumi-display">

        <?php
        for ($i = 1; $i <= 5; $i++) 
            {
                $row = mysqli_fetch_assoc($result);
                echo
                "
                <div class='album'>
                    <div class='album-cover'>    
                        <img src='slike/".$row["album_id"].".jpg' alt='".$row["naslov"]."' height='220' width='220'>
                    </div>
                    <div class='album-desc'>
                    <p class='album-naslov'>".$row["naslov"]."</p>
                    <div class='album-opis'>
                        <p>".$row["izvajalec_ime"]."</p>
                        <p>".$row["leto_izdaje"]."</p>
                        <p>".$row["zanr"]."</p>
                    </div>
                    <div class='album-button'>
                        <button><a href='../album.php/?id=".$row["album_id"]."'>View</a></button>
                        <button><a href='../add_to_cart.php/?id=".$row["album_id"]."'>Buy</a></button>
                    </div>
                </div>
            </div>  
            ";
            }     
        ?>
        </div>
        <div class="albumi-napis">
            <div>Progressive Rock</div>
        </div>
        <div class="albumi-display">
            <?php
                $result = mysqli_query($conn, $sql2);
                $num_r = mysqli_num_rows($result);
                for ($i = 1; $i <= 5; $i++) 
                {
                $row = mysqli_fetch_assoc($result);
                echo
                "
                <div class='album'>
                    <div class='album-cover'>    
                        <img src='slike/".$row["album_id"].".jpg' alt='".$row["naslov"]."' height='220' width='220'>
                    </div>
                    <div class='album-desc'>
                    <p class='album-naslov'>".$row["naslov"]."</p>
                    <div class='album-opis'>
                        <p>".$row["izvajalec_ime"]."</p>
                        <p>".$row["leto_izdaje"]."</p>
                        <p>".$row["zanr"]."</p>
                    </div>
                    <div class='album-button'>
                        <button><a href='../album.php/?id=".$row["album_id"]."'>View</a></button>
                        <button><a href='../add_to_cart.php/?id=".$row["album_id"]."'>Buy</a></button>
                    </div>
                    </div>
                    </div>  
                    ";
                    }     
        ?>
        </div>
    </main>
    <footer>
        <p><address>Avtor: Lenart Iršič</address></p>
    </footer>
</body>
</html>