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

if (!isset($_SESSION["prijavljen"]) || $_SESSION["prijavljen"] !== true) 
{
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) 
{
    $uporabnik_id = $_SESSION["id"];
    $album_id = $_GET['id'];

    $sql_kosarica = "SELECT kosarica_id FROM kosarica WHERE uporabnik_id = $uporabnik_id";
    $res_kosarica = mysqli_query($conn, $sql_kosarica);

    if (mysqli_num_rows($res_kosarica) == 1) 
    {
        $row_k = mysqli_fetch_assoc($res_kosarica);
        $kosarica_id = $row_k['kosarica_id'];
    } 
    else 
    {
        $sql_ustvari = "INSERT INTO kosarica (uporabnik_id) VALUES ($uporabnik_id)";
        mysqli_query($conn, $sql_ustvari);
        $kosarica_id = mysqli_insert_id($conn);
    }

    $sql_dodaj = "INSERT INTO kosarica_vsebina (kosarica_id, album_id, kolicina) VALUES ($kosarica_id, $album_id, 1) ON DUPLICATE KEY UPDATE kolicina = kolicina + 1";
    
    if (mysqli_query($conn, $sql_dodaj)) 
    {
        header("Location: ../cart.php");
        exit();
    } 
    else 
    {
        echo "Napaka pri posodabljanju košarice: " . mysqli_error($conn);
    }

} 
else 
{
    header("Location: ../index.php");
    exit();
}
?>