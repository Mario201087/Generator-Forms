<?php
session_start();
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Trim leading and trailing whitespaces
    $username = trim($username);
    $password = trim($password);

    // Retrieve hashed password from the database
    $retrieveQuery = "SELECT password FROM users WHERE username = ?";
    $retrieveStmt = $conn->prepare($retrieveQuery);
    $retrieveStmt->bind_param("s", $username);
    $retrieveStmt->execute();
    $retrieveResult = $retrieveStmt->get_result();

    if ($retrieveResult->num_rows > 0) {
        $userData = $retrieveResult->fetch_assoc();
        $hashedPassword = $userData['password'];

        // Verify password
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['login'] = $username; // Set login session variable
            header("Location: index.php"); // Redirect to index.php
            exit();
        } else {
            $_SESSION['error'] = 'Incorrect password';
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = 'Username not found';
        header("Location: login.php");
        exit();
    }

    $retrieveStmt->close();
}

$conn->close();
?>
