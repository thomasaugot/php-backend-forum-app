<?php
include '../db.php';

// User Registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER['REQUEST_URI'], '/forum-app/backend/api/user/register') !== false) {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->username) && isset($data->password)) {
        $username = $data->username;
        $password = password_hash($data->password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            echo json_encode(["message" => "User registered successfully."]);
        } else {
            echo json_encode(["message" => "Error: " . $stmt->error]);
        }

        $stmt->close();
        exit;
    } else {
        echo json_encode(["message" => "Username and password are required."]);
        exit;
    }
}

// User Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER['REQUEST_URI'], '/forum-app/backend/api/user/login') !== false) {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->username) && isset($data->password)) {
        $username = $data->username;
        $password = $data->password;

        $sql = "SELECT password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                echo json_encode(["message" => "Login successful."]);
            } else {
                echo json_encode(["message" => "Invalid password."]);
            }
        } else {
            echo json_encode(["message" => "User not found."]);
        }

        $stmt->close();
        exit;
    } else {
        echo json_encode(["message" => "Username and password are required."]);
        exit;
    }
}
