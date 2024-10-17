<?php
include '../db.php';

// Handle liking a post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER['REQUEST_URI'], '/like/create') !== false) {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->post_id) && isset($data->user_id)) {
        $post_id = $data->post_id;
        $user_id = $data->user_id;

        $sql = "INSERT INTO likes (post_id, user_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $post_id, $user_id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Post liked successfully."]);
        } else {
            echo json_encode(["message" => "Error: " . $stmt->error]);
        }

        $stmt->close();
        exit;
    } else {
        echo json_encode(["message" => "Post ID and User ID are required."]);
        exit;
    }
}

// Handle unliking a post
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && strpos($_SERVER['REQUEST_URI'], '/like/delete') !== false) {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->post_id) && isset($data->user_id)) {
        $post_id = $data->post_id;
        $user_id = $data->user_id;

        $sql = "DELETE FROM likes WHERE post_id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $post_id, $user_id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Post unliked successfully."]);
        } else {
            echo json_encode(["message" => "Error: " . $stmt->error]);
        }

        $stmt->close();
        exit;
    } else {
        echo json_encode(["message" => "Post ID and User ID are required."]);
        exit;
    }
}

// Handle fetching likes for a post
if ($_SERVER['REQUEST_METHOD'] === 'GET' && strpos($_SERVER['REQUEST_URI'], '/like/all') !== false) {
    if (isset($_GET['post_id'])) {
        $post_id = intval($_GET['post_id']);
        $sql = "SELECT u.username FROM likes l JOIN users u ON l.user_id = u.id WHERE l.post_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $likes = [];
        while ($row = $result->fetch_assoc()) {
            $likes[] = $row;
        }

        echo json_encode($likes);
        exit;
    } else {
        echo json_encode(["message" => "Post ID is required."]);
        exit;
    }
}
