<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horror Search</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
</head>
<body>
    <h2>login</h2>
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