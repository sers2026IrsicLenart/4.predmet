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

$uporabnik_id = $_SESSION["id"];
$sql_prazni = "DELETE FROM kosarica_vsebina WHERE kosarica_id = (SELECT kosarica_id FROM kosarica WHERE uporabnik_id = $uporabnik_id);";

if (mysqli_query($conn, $sql_prazni)) 
{
    header("Location: ../cart.php");
    exit();
} 
else 
{
    echo "Napaka pri checkoutu: " . mysqli_error($conn);
}
?>