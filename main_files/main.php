<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monster Request</title>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" type="image/x-icon" href="./assets/favicon.webp">
    <script src="scripts.js"></script>
</head>
<body onload="goToPage(1)">

    <main class="page" id="page1">
            <header>
                <h1 style="color: white; text-align: center; font-size: 50px;">Monster Energy<h2 style="color: white; text-align: center;"> Search!</h2></h1>
            </header>
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

            <?php 
            $list_drinks = array('1.webp', '17.png', '5.webp', '2.webp', '9.png', '31.webp', '22.webp', '23.png', '33.webp', '20.webp')
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
        
        <br><br><br>

        <h2 style="color: white; font-size: 40px; text-align: left;">What is this for?</h2>
        <p style="color: white; font-size: 20px; text-align: left; margin-right: 800px;">
            Creating a site where people can suggest new Monster Energy
            flavors gives fans a place to unleash their chaotic creativity while giving us a steady stream
            of insights into what people actually want. It builds hype, strengthens the community, and
            doubles as low-cost research since the voting and comments reveal which ideas have real
            traction. Plus, it opens doors for viral moments, limited-edition collabs, and a loyal user
            base that feels involved instead of ignored.
        </p>
        <h2 style="color: white; font-size: 40px; text-align: right;">What can you do?</h2>
        <p style="color: white; font-size: 20px; text-align: right; margin-left: 800px;">
            In this place you can search for existing monsters <br>
            You can make your own suggestions <br>
            You can search existing monster suggestions <br>
            You can comment on existing monsters
        </p>
        <div class="container">
            <button class="Search" onmousedown="goToPage(2)">Search</button>
            <button class="Request">Request Tastes</button>
            <button class="Credits">Who made this?</button>
        </div>
    </main>

    <div class="page" id="page2">
        <h1>All Monsters</h1>
        <p >Search up all kinds of monsters.</p>
        <h1>Random Monster!</h1>
        <?php
            // Fetch a random monster from the database
            $randomSql = "SELECT * FROM `monster_drinks` ORDER BY RAND() LIMIT 1";
            $randomResult = $conn->query($randomSql);
            if ($randomResult->num_rows > 0) {
                $randomRow = $randomResult->fetch_assoc();
                echo "<h1>" . $randomRow['drink_name'] . "</h1>";
                echo "<h3>" . $randomRow['flavor_description'] . "</h3>";
                $id = $randomRow['drink_id'];
                $relDir = 'assets/drinks/';
                $webpPath = $relDir . $id . '.webp';
                $pngPath  = $relDir . $id . '.png';

                // check filesystem using absolute path
                $fsWebp = __DIR__ . '/' . $webpPath;
                $fsPng  = __DIR__ . '/' . $pngPath;

                if (file_exists($fsWebp)) {
                    $src = $webpPath;
                } elseif (file_exists($fsPng)) {
                    $src = $pngPath;
                } else {
                    // fallback to webp path (will show broken image) or use a placeholder
                    $src = $webpPath;
                }

                echo "<img src='" . htmlspecialchars($src, ENT_QUOTES) . "' alt='" . htmlspecialchars($randomRow['drink_name'], ENT_QUOTES) . "' class='drink'>";
            }
        ?>
        <!-- <img src="./assets/drinks/SEBASTIAN.jpg" alt="" class="drink"> -->
    </div>


</body>
</html>