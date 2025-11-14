<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monster Request</title>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" type="image/x-icon" href="./assets/favicon.webp">
</head>
<body>
    <header>
        <h1 style="color: white; text-align: center; font-size: 50px;">Monster Energy<h2 style="color: white; text-align: center;"> Search!</h2></h1>
    </header>

    <main>
        <?php
            // Database connection (update credentials)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "monster_energy";

            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM `monster_drinks`";
            $result = $conn->query($sql);

        ?>
    </main>

    <?php 
    $list_drinks = array('1.webp', '3.png', '5.webp', '2.webp', '9.png', '31.webp', '22.webp', '23.png', '33.webp', '20.webp')
    ?>
    <div class="Slider" style="border: solid rgba(0, 0, 0, 0.468); 5px;">
    <div class="slide-track">
        <?php
            foreach ($list_drinks as $d) {
                echo <<<HTML
                <div class='Material' style="border: solid black 5px;">
                    <img 
                        src='assets/drinks/$d' 
                        alt='Drink $d' 
                        class='drink'
                    >
                    <div class='middle'>
                        <div class="text">Press for more info</div>
                    </div>
                </div>
            HTML;
            }

            // duplicate for smooth loop
            foreach ($list_drinks as $d) {
                echo <<<HTML
                <div class='Material' style="border: solid black 5px;">
                    <img 
                        src='assets/drinks/$d' 
                        alt='Drink $d' 
                        class='drink'
                    >
                    <div class='middle'>
                        <div class="text">Press for more info</div>
                    </div>
                </div>
            HTML;
            }
        ?>
    </div>
    </div>



</body>
</html>