<?php
    session_start();
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "predmet4";

    $uporabnik_id = $_SESSION["id"];

    $conn = mysqli_connect($hostname, $username, $password, $database);

    if (!$conn) 
        {
        die("Napaka pri povezavi z bazo: " . mysqli_connect_error());
        }

    $sql1 = "SELECT a.album_id, i.izvajalec_ime, a.zanr, a.leto_izdaje, a.naslov, a.cena, kv.kolicina, a.format FROM uporabniki u JOIN kosarica k ON u.uporabnik_id = k.uporabnik_id
    JOIN kosarica_vsebina kv ON k.kosarica_id = kv.kosarica_id JOIN albumi a ON kv.album_id = a.album_id JOIN izvajalci i ON a.izvajalec_id = i.izvajalec_id
    WHERE u.uporabnik_id = $uporabnik_id;";

    $sql_cena = "SELECT SUM(a.cena * kv.kolicina) AS skupna_cena FROM uporabniki u
    JOIN kosarica k ON u.uporabnik_id = k.uporabnik_id JOIN kosarica_vsebina kv ON k.kosarica_id = kv.kosarica_id JOIN albumi a ON kv.album_id = a.album_id
    WHERE u.uporabnik_id = $uporabnik_id;";

    $result_cena = mysqli_query($conn, $sql_cena);
    $row_cena = mysqli_fetch_assoc($result_cena);

    $cena = $row_cena['skupna_cena'] ?? 0;

    $result = mysqli_query($conn, $sql1);
    $num_r = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    include('search.php');
    ?>

    <?php
    include('navigacija.php');
    ?>
    <main>
        <div id="cart-main">
        <div id="cart-results">
        <?php  
        for ($i = 1; $i <= $num_r; $i++)
            {  
                $row = mysqli_fetch_assoc($result);
                echo "
                <div class='cart-item'>
                    <div class='cart-item-left'>
                    <div class='cart-item-cover'>
                        <img src='slike/".$row["album_id"].".jpg' alt='".$row["naslov"]."' height='162px' width='162px'>
                    </div>
                    <div class='cart-item-desc'>
                    <div class='cart-item-title'><a href='../album.php/?id=".$row["album_id"]."'>".$row["naslov"]."</a></div>
                    <div>".$row["izvajalec_ime"]."</div>
                    <div>".$row["leto_izdaje"]."</div>
                    <div>".$row["zanr"]."</div>
                    <div>".$row["cena"]."€</div>
                </div>
                </div>
                <div class='cart-item-buttons'>
                    <button><a href='remove_from_cart.php?id=".$row["album_id"]."'>Remove</a></button>
                </div>
                </div>
                ";
            }
        ?>
        </div>
        <div id="cart-checkout">
            <h3>Cart Content</h3>
            <?php  
                $result = mysqli_query($conn, $sql1);
                $num_r = mysqli_num_rows($result);
                for ($i = 1; $i <= $num_r; $i++)
                    {
                        $row = mysqli_fetch_assoc($result);
                        echo "<div>".$row["naslov"]." ".$row["kolicina"]."x</div>";
                    }
            ?>
            <div id="checkout-price"><?php echo $cena;?>€</div>
            <button><a href="checkout.php">Checkout</a></button>
        </div>
        </div>
    </main>
    <footer>
        <p><address>Avtor: Lenart Iršič</address></p>
        </div>
    </footer>
</body>
</html>