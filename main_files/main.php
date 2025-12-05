<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monster Request</title>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" type="image/x-icon" href="./assets/favicon.webp">
    <script src="./scripts.js"></script>
</head>
<body onload="goToPage(1)">

    <!-- Top-right menu toggle -->
    <div id="bgMenuToggle">&#9776;</div>

    <!-- Menu panel -->
    <div id="bgMenuPanel">
        <h3>Backgrounds</h3>
        <button data-bg="green-black">Black + Green</button>
        <button data-bg="white-silver">White + Silver</button>
        <button data-bg="blue-yellow">Blue + Yellow</button>
        <button data-bg="brown-golden">Brown + Golden</button>
        <button data-bg="red-black">Red + Black</button>
    </div>


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
                $list_drinks = array('1.webp', '17.png', '5.webp', '2.webp', '9.png', '31.webp', '22.webp', '23.png', '33.webp', '20.webp');

                // Cache drinks from the DB
                $allSql = "SELECT * FROM `monster_drinks`";
                $allResult = $conn->query($allSql);
                $drinks = [];

                if ($allResult->num_rows > 0) {
                    while ($row = $allResult->fetch_assoc()) {
                        $drinks[$row['drink_id']] = $row;
                    }
                }

                function detectImage($d) {
                    return "assets/drinks/$d";
                }

                ?>

                <div class="Slider">
                    <div class="slide-track">

                        <?php
                            // MAIN LOOP
                            foreach ($list_drinks as $d) {
                                $id = intval(pathinfo($d, PATHINFO_FILENAME));
                                $drink = $drinks[$id] ?? null;

                                $name = $drink ? htmlspecialchars($drink['drink_name'], ENT_QUOTES) : '';
                                $desc = $drink ? htmlspecialchars($drink['flavor_description'], ENT_QUOTES) : '';
                                $disc = $drink ? intval($drink['discontinued']) : 0;
                                $category_id = $drink ? htmlspecialchars($drink['category_id'], ENT_QUOTES) : '';

                                $src = detectImage($d);

                                echo <<<HTML
                                <div class="Material drink-card"
                                    data-name="$name"
                                    data-desc="$desc"
                                    data-src="$src"
                                    data-discontinued="$disc"
                                    data-category='$category_id'
                                    style="border: solid black 5px;">
                                    
                                    <img src="$src" alt="$name" class="drink">
                                    <div class="middle">
                                        <div class="text">Press for more info</div>
                                    </div>
                                </div>
                                HTML;
                            }

                            // DUPLICATE LOOP
                            foreach ($list_drinks as $d) {
                                $id = intval(pathinfo($d, PATHINFO_FILENAME));
                                $drink = $drinks[$id] ?? null;

                                $name = $drink ? htmlspecialchars($drink['drink_name'], ENT_QUOTES) : '';
                                $desc = $drink ? htmlspecialchars($drink['flavor_description'], ENT_QUOTES) : '';
                                $disc = $drink ? intval($drink['discontinued']) : 0;

                                $src = detectImage($d);

                                echo <<<HTML
                                <div class="Material drink-card"
                                    data-name="$name"
                                    data-desc="$desc"
                                    data-src="$src"
                                    data-discontinued="$disc"
                                    style="border: solid black 5px;">
                                    
                                    <img src="$src" alt="$name" class="drink">
                                    <div class="middle">
                                        <div class="text">Press for more info</div>
                                    </div>
                                </div>
                                HTML;
                            }
                        ?>

                    </div>
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
            <button class="Search" onmousedown="goToPage(2, -400)">Search</button>
            <button class="Request" onmousedown="goToPage(3, -400)">Request Tastes</button>
            <button class="Credits" onmousedown="goToPage(4, -400)">Who made this?</button>
        </div>
    </main>

    <div class="page" id="page2">
        <div class="container">
            <button class="Search" onmousedown="goToPage(1)">Main</button>
            <button class="Request">Request Tastes</button>
            <button class="Credits">Who made this?</button>
        </div>
        <br><br><br>
        <h1>All Monsters</h1>
        <p >Search up all kinds of monsters.</p>
        
        <div class="search-container">
            <div class="top">
                <input type="text" id="searchbar" onkeyup="filterMonsters()" placeholder="Search for monsters..">
                <div id="searchResults" class="search-results-grid">
                    <?php
                        // Fetch all monsters from database
                        $allSql = "SELECT * FROM `monster_drinks` ORDER BY drink_name";
                        $allResult = $conn->query($allSql);
                        
                        if ($allResult->num_rows > 0) {
                            while($row = $allResult->fetch_assoc()) {
                                $id = $row['drink_id'];
                                $name = htmlspecialchars($row['drink_name'], ENT_QUOTES);
                                $description = htmlspecialchars($row['flavor_description'], ENT_QUOTES);
                                $disc = $row ? intval($row['discontinued']) : 0;
                                $category_id = htmlspecialchars($row['category_id'], ENT_QUOTES);
                                
                                $relDir = 'assets/drinks/';
                                $webpPath = $relDir . $id . '.webp';
                                $pngPath  = $relDir . $id . '.png';
                                $fsWebp = __DIR__ . '/' . $webpPath;
                                $fsPng  = __DIR__ . '/' . $pngPath;
                                
                                if (file_exists($fsWebp)) {
                                    $src = $webpPath;
                                } elseif (file_exists($fsPng)) {
                                    $src = $pngPath;
                                } else {
                                    $src = $webpPath;
                                }
                                
                                // Render the card with data attributes so JS can open modal safely
                                // Use HTML-escaped values for attributes to avoid breaking markup
                                $srcAttr = htmlspecialchars($src, ENT_QUOTES);
                                echo <<<HTML
                                <div class='drink-card' data-name="{$name}" data-desc="{$description}" data-src="{$srcAttr}" data-category='$category_id'>
                                    <img src='$src' alt='$name' class='drink-thumbnail'>
                                    <h3>$name</h3>
                                    <h6 class='flavor-desc'>$description</h6>
                                </div>
                            HTML;
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="mid">

            </div>
        </div>
        <div class="bottom">
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
                    $category_id = htmlspecialchars($randomRow['category_id'], ENT_QUOTES);
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

                    echo "<img src='" . htmlspecialchars($src, ENT_QUOTES) . "' alt='" . htmlspecialchars($randomRow['drink_name'], ENT_QUOTES) . "' class='drink drink-card' data-name=\"" . htmlspecialchars($randomRow['drink_name'], ENT_QUOTES) . "\" data-desc=\"" . htmlspecialchars($randomRow['flavor_description'], ENT_QUOTES) . "\" data-src='" . htmlspecialchars($src, ENT_QUOTES) . "' data-discontinued=\"$disc\" data-category='$category_id'> ";
                }
            ?>
            <!-- <img src="./assets/drinks/SEBASTIAN.jpg" alt="" class="drink"> -->
        </div>
    </div>


    <!-- Drink Details Modal: hidden by default, populated and shown via JS -->
    <div id="drinkModal" class="drink-modal" aria-hidden="true">
        <div class="modal-content" role="dialog" aria-modal="true" aria-labelledby="modalDrinkName">
            <button class="close-btn" id="modalCloseBtn" aria-label="Close">&times;</button>
            <div class="modal-body">
                <div class="modal-image-container">
                    <img id="modalDrinkImage" src="" alt="" class="modal-drink-image">
                </div>
                <div class="modal-details">
                    <h3 style="font-size: 1.5em;" id="modalDrinkName"></h3>
                    <h6 style="font-size: 1em;" id="modalDrinkDescription" class="modal-description"></h6>
                </div>
            </div>
            <div id="modalStatus" class="drink-status"></div>
        </div>
    </div>
    <div class="page" id="page3">
        <!---
        <h1>Request Tastes</h1>
        <p>
            <label>Comments</label><br>
            <textarea cols="40" rows="2" placeholder="comments"></textarea>
        </p>
            -->
        <form action="#" method="diolog">
            <section class="chatbox1">
                <p>
                <label>Email</label><br>
                    <input type="email" name="email" required="" placeholder="Email">
                </p>
                <p>
                    <label>Name</label><br>
                    <input type="text" name="Name" required="" placeholder="Full Name" >
                </p>
                <p>
                    <label>Country</label><br>
                    <select>
                        <option name="China">China</option>
                        <option>India</option>
                        <option>United States</option>
                        <option>Indonesia</option>
                        <option>Brazil</option>
                    </select>
                </p>
                <p>
                    <label>phone number</label><br>
                    <input type="tel" name="phone-number" placeholder="7 digids">
                </p>
                <p>
                    <label>Suggest flavor</label><br>
                    <textarea cols="40" rows="4" placeholder="comments"></textarea>
                </p>
                
                <p>
                    <label>
                        <input type="checkbox" value="terms" required="">
                        I agree to the <a>terms and conditions</a>
                    </label>
                </p>
                <p>
                    <label>
                        <input type="checkbox" value="terms">
                        subscribe
                    </label>

                </p>
                <p>
                    <input type="submit" value="senda">
                </p>
            </section>
        </form>


        <div class="container">
            <button class="Search" onmousedown="goToPage(1)">Main</button>
            <button class="Request" onmousedown="goToPage(2)">Search</button>
            <button class="Credits" onmousedown="goToPage(4)">Who made this?</button>
        </div>
    </div>
    <div class="page" id="page4">
        <!---Who made this-->
        <p style="text-align: center;">The people who made this website:</p>
            <h1>Asbjørn Stephan Kastvig Abbas</h1>
            <h1 style="padding-bottom: 2em;">Hrafn Flóki Pétursson</h1>
        <p style="text-align: center;">UFC Fighter sponsers:</p>
            <h1>Valentina Shevchenko</h1>
            <h1>Weili Zhang</h1>
            <h1 style="padding-bottom: 2em;">Georges St-Pierre</h1>

        <p style="text-align: center;">Monster energy sponsering snow boarders:</p>
                <h1>Dusty Henricksen</h1>
                <h1 style="padding-bottom: 2em;">Cameron Spalding</h1>

        <p style="text-align: center;">Sponsering motor cycelists:</p>
                <h1>takayuki Higashino</h1>
                <h1>Chase Sexton</h1>


        <div class="container">
            <button class="Search" onmousedown="goToPage(1)">Main</button>
            <button class="Request" onmousedown="goToPage(3)">Request Tastes</button>
            <button class="Request" onmousedown="goToPage(2)">Search</button>
        </div>
</body>
</html>