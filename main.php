<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monster Request</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
    <link rel="icon" type="image/x-icon" href="assets/favicon.webp">
</head>
<body>
    <header>
        <h1>Monsters</h1>
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

        // Only build the slider if there are results
        if ($result && $result->num_rows > 0) {
            echo '<div class="slider"><div class="slides">';
            while ($row = $result->fetch_assoc()) {
                $drink_id = htmlspecialchars($row['drink_id']);
                $drink_name = htmlspecialchars($row['drink_name']);
                $flavor_description = htmlspecialchars($row['flavor_description']);

                $webp_path = "assets/drinks/{$drink_id}.webp";
                $png_path  = "assets/drinks/{$drink_id}.png";
                $no_image  = "assets/drinks/no-image.png";

                if (file_exists($webp_path)) {
                    $img_src = $webp_path;
                } elseif (file_exists($png_path)) {
                    $img_src = $png_path;
                } else {
                    $img_src = $no_image;
                }

                echo "
                <div class='slide'>
                    <img src='{$img_src}' alt='{$drink_name}' />
                    <div class='info'>
                        <strong>{$drink_name}</strong><br>
                        <small>ID: {$drink_id}</small><br>
                        <em>{$flavor_description}</em>
                    </div>
                </div>";
            }
            echo '</div></div>';
        }
        $conn->close();
    ?>
</main>


<style>
    body {
    background: #111;
    color: #fff;
    font-family: Arial, sans-serif;
    text-align: center;
    }

    .slider {
    width: 400px;
    height: 280px;
    margin: 50px auto;
    overflow: hidden;
    border-radius: 12px;
    border: 2px solid #555;
    position: relative;
    }

    .slides {
    display: flex;
    transition: transform 0.6s ease-in-out;
    }

    .slide {
    min-width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    }

    .slide img {
    max-width: 150px;
    border-radius: 8px;
    margin-bottom: 10px;
    }

    .info {
    text-align: center;
    line-height: 1.3;
    }

</style>
</head>
<body>

<div class="slider">
    <div class="slides" id="slides"></div>
</div>

<script>
  // Customizable slide IDs — just change this array:
  const ids = [4, 12, 42];

  const slidesContainer = document.getElementById('slides');

document.addEventListener("DOMContentLoaded", () => {
  const slidesContainer = document.querySelector(".slides");
  if (!slidesContainer) return;

  const slides = slidesContainer.children;
  if (slides.length === 0) return;

  const firstClone = slides[0].cloneNode(true);
  slidesContainer.appendChild(firstClone);

  let index = 0;
  const total = slides.length - 1;

  function autoSlide() {
    index++;
    slidesContainer.style.transform = `translateX(-${index * 100}%)`;

    if (index === total) {
      setTimeout(() => {
        slidesContainer.style.transition = "none";
        index = 0;
        slidesContainer.style.transform = "translateX(0)";
        setTimeout(() => {
          slidesContainer.style.transition = "transform 0.6s ease-in-out";
        });
      }, 600);
    }
  }

  setInterval(autoSlide, 2500);
});

</script>

</body>
</html>