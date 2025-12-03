<?php
    session_start();

    // Must be logged in
    if (!isset($_SESSION['username'])) {
        header("Location: ../index.php");
        exit();
    }

    $servername = "localhost";
    $usernameDB = "root";
    $passwordDB = "";
    $dbname = "monster_accounts";

    $conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

    $user = $_SESSION['username'];

    $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();

    session_unset();
    session_destroy();

    header("Location: ../index.php");
    exit();
?>
