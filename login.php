<?php

session_start();

include("utils.php");

if (empty($_POST["email"])) {
    http_response_code(400);
    die("email is required");
}
if (empty($_POST["password"])) {
    http_response_code(400);
    die("password is required");
}

$email = $_POST["email"];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    die("invalid email address");
}

$password = EncryptPassword($_POST["password"]);

$xmlFile = file_get_contents("customer.xml");
$xml = simplexml_load_string($xmlFile);
for ($i = 0; $i < count($xml); $i++) {
    if ($email == $xml->user[$i]->email) {
        if ($password == $xml->user[$i]->password) {
            $_SESSION["loginSession"] = 1;
            http_response_code(200);
            $response = new stdClass();
            $response->id = (int) $xml->user[$i]->id;
            $response->email = (string) $xml->user[$i]->email;
            $response->lastname = (string) $xml->user[$i]->lastname;
            $response->firstname = (string) $xml->user[$i]->firstname;
            $response->phone_no = (string) $xml->user[$i]->phone_no;
            die(json_encode($response));
        } else {
            http_response_code(500);
            die("wrong password");
        }
    }
}

http_response_code(404);
die("record not found");
?>