<?php

session_start();

include("utils.php");

if (empty($_POST["username"])) {
    http_response_code(400);
    die("username is required");
}
if (empty($_POST["password"])) {
    http_response_code(400);
    die("password is required");
}

$username = trim($_POST["username"]);
$password = trim($_POST["password"]);

$txtFile = fopen("data/manager.txt", "r");
while ($row = fgets($txtFile)) {
    $splittedRow = explode(",", $row);
    $thisUsername = trim($splittedRow[0]);
    $thisPassword = trim($splittedRow[1]);
    if ($thisUsername == $username) {
        if ($thisPassword == $password) {
            http_response_code(200);
            $_SESSION["manager"] = (string) $username;
            die($username);
        } else {
            http_response_code(400);
            die("wrong password");
        }
    }
}

http_response_code(404);
die("record not found");
?>