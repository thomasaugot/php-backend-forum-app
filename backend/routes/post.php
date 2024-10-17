<?php
include '../db.php';

// Handle creating a post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER['REQUEST_URI'], '/post/create') !== false) {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->user_id) && isset($data->title) && isset($data->content)) {
        $user_id = $data->user_id;
        $title = $data->title;
        $content = $data->content;

        $sql = "INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $user_id, $title, $content);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Post created successfully."]);
        } else {
            echo json_encode(["message" => "Error: " . $stmt->error]);
        }

        $stmt->close();
        exit;
    } else {
        echo json_encode(["message" => "User ID, title, and content are required."]);
        exit;
    }
}

// Handle updating a post
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && strpos($_SERVER['REQUEST_URI'], '/post/update') !== false) {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->id) && isset($data->title) && isset($data->content)) {
        $id = $data->id;
        $title = $data->title;
        $content = $data->content;

        $sql = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $title, $content, $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Post updated successfully."]);
        } else {
            echo json_encode(["message" => "Error: " . $stmt->error]);
        }

        $stmt->close();
        exit;
    } else {
        echo json_encode(["message" => "Post ID, title, and content are required."]);
        exit;
    }
}

// Handle deleting a post
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && strpos($_SERVER['REQUEST_URI'], '/post/delete') !== false) {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->id)) {
        $id = $data->id;

        $sql = "DELETE FROM posts WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Post deleted successfully."]);
        } else {
            echo json_encode(["message" => "Error: " . $stmt->error]);
        }

        $stmt->close();
        exit;
    } else {
        echo json_encode(["message" => "Post ID is required."]);
        exit;
    }
}

// Handle fetching all posts
if ($_SERVER['REQUEST_METHOD'] === 'GET' && strpos($_SERVER['REQUEST_URI'], '/post/all') !== false) {
    $sql = "SELECT p.id, p.title, p.content, p.created_at, u.username FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC";
    $result = $conn->query($sql);

    $posts = [];
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }

    echo json_encode($posts);
    exit;
}
