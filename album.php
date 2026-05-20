<?php
    session_start();
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "predmet4";

    $album_id = isset($_GET["id"]) ? $_GET["id"] : 1; /*RAZLAGA V POROČILU*/

    $conn = mysqli_connect($hostname, $username, $password, $database);

    if (!$conn) 
        {
        die("Napaka pri povezavi z bazo: " . mysqli_connect_error());
        }

    $sql1 = "SELECT * FROM albumi a JOIN izvajalci i ON a.izvajalec_id = i.izvajalec_id WHERE a.album_id = $album_id";
        
    $result = mysqli_query($conn, $sql1);
    $row = mysqli_fetch_assoc($result);

    $zanr = $row["zanr"];

    $sql2 = "SELECT a.*, i.izvajalec_ime FROM albumi a JOIN izvajalci i ON a.izvajalec_id = i.izvajalec_id 
    WHERE a.album_id != $album_id 
    ORDER BY (a.zanr = '$zanr') DESC, RAND() LIMIT 5";

    $sql3 = "SELECT naslov FROM albumi WHERE album_id = $album_id";
    $result_naslov = mysqli_query($conn, $sql3);
    $row_naslov = mysqli_fetch_assoc($result_naslov);
    $naslov_albuma = $row_naslov["naslov"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $naslov_albuma?></title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php
    include('search.php');
    ?>

    <?php
    include('navigacija.php');
    ?>
    <main>
        <div id="album-nakup">
            <?php
            echo "
            <div id='album-zgornji-del'>
                <div id='album-slika'>
                    <img src='../slike/".$row["album_id"].".jpg' alt='album_cover' height='550' width='550'>
                </div>
                <div id='album-podatki'>
                    <div id='album-naslov'>
                        ".$row["naslov"]."
                    </div>
                    <div id='album-podrobni-opis'>
                        <div>Author: <a href='../search_result.php?search_query=".$row["izvajalec_ime"]."'>".$row["izvajalec_ime"]."</a></div>
                        <div>Format: ".$row["format"]."</div>
                        <div>Released: ".$row["leto_izdaje"]."</div>
                        <div>Genre: ".$row["zanr"]."</div>

                        <div>Stock: ".$row["zaloga"]."</div>
                        <div id='album-cena'>".$row["cena"]."€</div>
                    </div>
                    <div id='album-nakup-gumb'>
                        <a href=''><button><a href='../add_to_cart.php/?id=".$row["album_id"]."'>Add to cart</a></button></a>
                    </div>
                </div>
            </div>
            ";
            ?>

            <div id="album-spodnji-del">

            </div>
        </div>

        <!--priporoceni albumi - ISTI ŽANR-->
        <div class="albumi-napis">
            <div>Recomended</div>
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
                        <img src='../slike/".$row["album_id"].".jpg' alt='".$row["naslov"]."' height='220' width='220'>
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
        </div>
    </footer>
</body>
</html>