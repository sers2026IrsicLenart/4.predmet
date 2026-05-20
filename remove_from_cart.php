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
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) 
{
    $uporabnik_id = $_SESSION["id"];
    $album_id = ($_GET['id']);

    $sql_kosarica = "SELECT kosarica_id FROM kosarica WHERE uporabnik_id = $uporabnik_id";
    $res_kosarica = mysqli_query($conn, $sql_kosarica);

    if (mysqli_num_rows($res_kosarica) == 1) 
    {
        $row_k = mysqli_fetch_assoc($res_kosarica);
        $kosarica_id = $row_k['kosarica_id'];
        $sql_preveri = "SELECT kolicina FROM kosarica_vsebina WHERE kosarica_id = $kosarica_id AND album_id = $album_id";
        $res_preveri = mysqli_query($conn, $sql_preveri);

        if (mysqli_num_rows($res_preveri) == 1) 
        {
            $row_vsebina = mysqli_fetch_assoc($res_preveri);
            $trenutna_kolicina = $row_vsebina['kolicina'];

            if ($trenutna_kolicina > 1) 
            {
                $sql_akcija = "UPDATE kosarica_vsebina SET kolicina = kolicina - 1 WHERE kosarica_id = $kosarica_id AND album_id = $album_id";
            } 
            else 
            {
                $sql_akcija = "DELETE FROM kosarica_vsebina WHERE kosarica_id = $kosarica_id AND album_id = $album_id";
            }

            if (mysqli_query($conn, $sql_akcija)) 
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
            header("Location: ../cart.php");
            exit();
        }
    } 
    else 
    {
        header("Location: ../cart.php");
        exit();
    }

} 
else 
{
    header("Location: ../index.php");
    exit();
}
?>