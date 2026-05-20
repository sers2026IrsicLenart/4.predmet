<?php
session_start();

$hostname = "localhost";
$username = "root";
$password = "";
$database = "predmet4";
$conn = mysqli_connect("localhost", "root", "", "predmet4");

if (!$conn) 
{
    die("Napaka pri povezavi z bazo: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $email = $_POST['vnos_email'];
    $geslo = $_POST['vnos_geslo'];

    $sql = "SELECT * FROM uporabniki WHERE email='$email' AND geslo='$geslo'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) 
    {
        $uporabnik = mysqli_fetch_assoc($result);
        
        $_SESSION["prijavljen"] = true;
        $_SESSION["id"] = $uporabnik["uporabnik_id"];
        $_SESSION["ime"] = $uporabnik["ime"];

        header("Location: index.php"); 
        exit();
    } 
    else 
    {
        header("Location: login.php?napaka=1");
        exit();
    }
} 
else 
{
    header("Location: login.php");
    exit();
}
?>