<?php
session_start();
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['password_2'];

    // Trim leading and trailing whitespaces
    $username = trim($username);
    $password = trim($password);
    $confirmPassword = trim($confirmPassword);

    // Check if the passwords match
    if ($password !== $confirmPassword) {
        $_SESSION['error'] = 'Passwords do not match';
        header("Location: registration.php");
        exit();
    }

    // Check if the username already exists
    $checkQuery = "SELECT * FROM users WHERE username = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        $_SESSION['error'] = 'Username already taken';
        header("Location: registration.php");
        exit();
    } else {
        // Insert new user with hashed password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertQuery = "INSERT INTO users (username, password) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ss", $username, $hashedPassword);

        if ($insertStmt->execute()) {
            $_SESSION['login'] = $username; // Set login session variable
            header("Location: index.php"); // Redirect to index.php
            exit();
        } else {
            $_SESSION['error'] = 'Registration failed';
            header("Location: registration.php");
            exit();
        }

        $insertStmt->close();
    }

    $checkStmt->close();
}

$conn->close();
?>
