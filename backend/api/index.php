<?php
header("Content-Type: application/json");

$request_uri = $_SERVER['REQUEST_URI'];

// Remove the base URL part to simplify routing
$request_uri = str_replace('/forum-app/backend/api/index.php', '', $request_uri);

// Check for user routes
if (strpos($request_uri, '/user/register') === 0) {
    include '../routes/user.php';
} elseif (strpos($request_uri, '/user/login') === 0) {
    include '../routes/user.php';
}
// Check for post routes
elseif (strpos($request_uri, '/post/create') === 0) {
    include '../routes/post.php';
} elseif (strpos($request_uri, '/post/update') === 0) {
    include '../routes/post.php';
} elseif (strpos($request_uri, '/post/delete') === 0) {
    include '../routes/post.php';
} elseif (strpos($request_uri, '/post/all') === 0) {
    include '../routes/post.php';
} else {
    echo json_encode(["message" => "Invalid request."]);
}
