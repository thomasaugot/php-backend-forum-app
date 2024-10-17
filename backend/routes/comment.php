<?php
include '../db.php';

// Handle creating a comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER['REQUEST_URI'], '/comment/create') !== false) {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->post_id) && isset($data->user_id) && isset($data->content)) {
        $post_id = $data->post_id;
        $user_id = $data->user_id;
        $content = $data->content;

        $sql = "INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $post_id, $user_id, $content);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Comment added successfully."]);
        } else {
            echo json_encode(["message" => "Error: " . $stmt->error]);
        }

        $stmt->close();
        exit;
    } else {
        echo json_encode(["message" => "Post ID, User ID, and content are required."]);
        exit;
    }
}

// Handle fetching comments for a post
if ($_SERVER['REQUEST_METHOD'] === 'GET' && strpos($_SERVER['REQUEST_URI'], '/comment/all') !== false) {
    if (isset($_GET['post_id'])) {
        $post_id = intval($_GET['post_id']);
        $sql = "SELECT c.id, c.content, c.created_at, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE c.post_id = ? ORDER BY c.created_at DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }

        echo json_encode($comments);
        exit;
    } else {
        echo json_encode(["message" => "Post ID is required."]);
        exit;
    }
}
