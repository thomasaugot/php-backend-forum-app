<?php
include '../db.php';

// Handle fetching a user profile
if ($_SERVER['REQUEST_METHOD'] === 'GET' && strpos($_SERVER['REQUEST_URI'], '/profile') !== false) {
    if (isset($_GET['user_id'])) {
        $user_id = intval($_GET['user_id']);

        $sql = "SELECT username FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // Fetch user's posts
            $post_sql = "SELECT id, title, content, created_at FROM posts WHERE user_id = ?";
            $post_stmt = $conn->prepare($post_sql);
            $post_stmt->bind_param("i", $user_id);
            $post_stmt->execute();
            $post_result = $post_stmt->get_result();

            $posts = [];
            while ($post_row = $post_result->fetch_assoc()) {
                $posts[] = $post_row;
            }

            echo json_encode([
                "username" => $row['username'],
                "posts" => $posts
            ]);
        } else {
            echo json_encode(["message" => "User not found."]);
        }

        $stmt->close();
        exit;
    } else {
        echo json_encode(["message" => "User ID is required."]);
        exit;
    }
}
