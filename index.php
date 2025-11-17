<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horror Search</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
    <link rel="icon" type="image/x-icon" href="assets/favicon.webp">
    
</head>
<body>
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";

        $conn = new mysqli($servername, $username, $password);

        // Check connection
        if ($conn->connect_error) {
        echo "<script>console.log('Connection failed: " . $conn->connect_error . "');</script>";
        }
        echo "<script>console.log('Connected successfully');</script>";
    ?>

</body>
</html>