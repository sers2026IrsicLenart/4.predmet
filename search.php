<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <a href="../index.php"><img src="../slike/home.png" height="35px" width="35px" alt="Home"></a>
        <div class="search-container">
            <form action="../search_result.php" method="GET">
            <input type="text" placeholder="Search..." class="search-input" name="search_query">
            <input type="submit" class="search-button" value="Search">
            </form>
        </div>
        <div id="prijava-container">
        <p id="kosarica">
            <?php if (isset($_SESSION["prijavljen"]) && $_SESSION["prijavljen"] === true): ?>
                <a href="cart.php">
                    <img src="../slike/kosarica.jpg" height="35px" width="35px" alt="kosarica">
                </a>
            <?php else: ?>
                <a href="login.php">
                    <img src="../slike/kosarica.jpg" height="35px" width="35px" alt="kosarica">
                </a>
            <?php endif; ?>    
                </p>
        <p id="prijava"><a href="">
            <?php
                if (isset($_SESSION["prijavljen"]) && $_SESSION["prijavljen"] === true) {
                    echo $_SESSION["ime"]." | <a href='../logout.php'>Odjava</a>";
                } else {
                    echo "<a href='login.php'>Login</a>";
                }
            ?>
        </a></p>
        </div>
    </header>
</body>
</html>