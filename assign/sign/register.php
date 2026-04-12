<?php
require_once "../db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["userName"]);
    $email = trim($_POST["userEmail"]);
    $password = trim($_POST["userPwd"]);
    $confirmPwd = trim($_POST["confirmPwd"]);

    if (strlen($username) < 3) {
        die("Username must be at least 3 characters.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    if (strlen($password) < 8) {
        die("Password must be at least 8 characters.");
    }

    if ($password !== $confirmPwd) {
        die("Passwords do not match.");
    }

    $checkSql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("This email is already registered.");
    }
    $stmt->close();

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $insertSql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        header("Location: ../profile/profile.php?id=" . $stmt->insert_id);
        exit();
    } else {
        echo "Registration failed: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
