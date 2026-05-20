<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="form_main">
        <div id="form">
            <form action="login_proces.php" method="POST">
                <h3>Login</h3>
                <?php 
                if (isset($_GET['napaka']) && $_GET['napaka'] == 1) {
                    echo "<p style='color: red; font-weight: bold; text-align: center;'>Napačen email ali geslo!</p>";
                }
                ?>
                <div><input type="text" name="vnos_email" placeholder="Email"></div>
                <div><input type="password" name="vnos_geslo" placeholder="Password"></div>
                <div><input type="submit" id="form_submit_inner" value="Login"></div>
            </form>
        </div>
    </div>
    <footer>
        <p><address>Avtor: Lenart Iršič</address></p>
        </div>
    </footer>
</body>
</html>