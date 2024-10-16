<?php

// host
define("HOST", "localhost");

// dbname
define('DBNAME', 'forum-app');

// user
define('USER', 'root');

// password
define("PASS", "");

$conn = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME . "", USER, PASS);

if ($conn == true) {
    echo "db connection successful";
} else {
    echo "error connecting to db";
};
