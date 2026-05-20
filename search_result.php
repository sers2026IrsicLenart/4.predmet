<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    <link rel="stylesheet" href="style.css">
    <?php
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "predmet4";

        $conn = mysqli_connect($hostname, $username, $password, $database);

        if (!$conn) 
            {
            die("Napaka pri povezavi z bazo: " . mysqli_connect_error());
            }

        $query = $_GET["search_query"] ?? "";
        $price = $_GET["price"] ?? "";
        $format = $_GET["format"] ?? "";

        $sql = "SELECT a.*, i.izvajalec_ime FROM albumi a JOIN izvajalci i ON a.izvajalec_id = i.izvajalec_id WHERE 1=1";

        if (!empty($query)) {
            $sql .= " AND (a.zanr LIKE '%$query%' OR a.leto_izdaje LIKE '%$query%' OR a.naslov LIKE '%$query%' OR i.izvajalec_ime LIKE '%$query%' OR a.format LIKE '%$query%')";
        }

        if (!empty($price)) {
            if ($price == 'under20')  $sql .= " AND a.cena < 20";
            if ($price == '20-25')    $sql .= " AND a.cena BETWEEN 20 AND 25";
            if ($price == '25-30')    $sql .= " AND a.cena BETWEEN 25 AND 30";
            if ($price == '30-40')    $sql .= " AND a.cena BETWEEN 30 AND 40";
            if ($price == '40-60')    $sql .= " AND a.cena BETWEEN 40 AND 60";
            if ($price == 'above60')  $sql .= " AND a.cena > 60";
        }

        if (!empty($format)) {
            $sql .= " AND a.format = '$format'";
        }

        $sql .= " ORDER BY a.zaloga DESC;";
        $result = mysqli_query($conn, $sql);
        $num_r = mysqli_num_rows($result);
    ?>
</head>
<body>
    <?php include('search.php'); ?>
    <?php include('navigacija.php'); ?>    
    <main>
        <div id="search-outer">
            
            <div id="search-filter">
                <h2>Filter Results</h2>
                
                <h3>Price:</h3>
                <div><a href="search_result.php?search_query=<?php echo $query; ?>&price=under20">&lt; 20€</a></div>
                <div><a href="search_result.php?search_query=<?php echo $query; ?>&price=20-25">20€ - 25€</a></div>
                <div><a href="search_result.php?search_query=<?php echo $query; ?>&price=25-30">25€ - 30€</a></div>
                <div><a href="search_result.php?search_query=<?php echo $query; ?>&price=30-40">30€ - 40€</a></div>
                <div><a href="search_result.php?search_query=<?php echo $query; ?>&price=40-60">40€ - 60€</a></div>
                <div><a href="search_result.php?search_query=<?php echo $query; ?>&price=above60">60€ +</a></div>
                
                <h3>Format</h3>
                <div><a href="search_result.php?search_query=<?php echo $query; ?>&format=Vinyl">Vinyl</a></div>
                <div><a href="search_result.php?search_query=<?php echo $query; ?>&format=CD">CD</a></div>
                <div><a href="search_result.php?search_query=<?php echo $query; ?>&format=Cassette">Cassette</a></div>

                <br>
                <div><a href="search_result.php?search_query=<?php echo $query; ?>" style="color: red;">Clear Filters</a></div>
            </div>
            
            <div id="search-results">
                <div id="search-query">Results for: "<?php echo $query;?>"</div>
                <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "
                        <div class='search-result'>
                            <div class='search-cover'>
                                <img src='slike/".$row["album_id"].".jpg' alt='album_cover' height='162px' width='162px'>
                            </div>
                            <div class='search-desc'>
                                <div class='search-title'><a href='album.php?id=".$row["album_id"]."'>".$row["naslov"]."</a></div>
                                <div>".$row["izvajalec_ime"]."</div>
                                <div>".$row["leto_izdaje"]."</div>
                                <div>".$row["zanr"]."</div>
                                <div>".$row["cena"]."€</div>
                            </div>
                        </div>
                        ";
                    }
                ?>
            </div>
        </div>
    </main>
    <footer>
        <p><address>Avtor: Lenart Iršič</address></p>
    </footer>
</body>
</html>