<?php

include("utils.php");

if (empty($_POST["email"])) {
    http_response_code(400);
    die("Email is required");
}
$email = $_POST["email"];
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    die("invalid email address");
}

if (empty($_POST["lastname"])) {
    http_response_code(400);
    die("Last name is required");
}
$lastname = $_POST["lastname"];

if (empty($_POST["firstname"])) {
    http_response_code(400);
    die("First name is required");
}
$firstname = $_POST["firstname"];

if (empty($_POST["password"]) || $_POST["password"] == "d41d8cd98f00b204e9800998ecf8427e") {
    http_response_code(400);
    die("Password is required");
}
$password = HashPassword($_POST["password"]);
$phone_no = isset($_POST["phone_no"]) ? $_POST["phone_no"] : '';


$xmlFile = file_get_contents("customer.xml");
$xml = simplexml_load_string($xmlFile);

for ($i = 0; $i < $xml->count(); $i++) {
    if ($xml->user[$i]->email == $email) {
        http_response_code(400);
        die("email already exists");
    }
}

$incrementFile = file_get_contents("increment.xml");
$increment = simplexml_load_string($incrementFile);

$user = $xml->addChild('user');
$user->addChild('id', $increment->customer_id);
$user->addChild('email', $email);
$user->addChild('lastname', $lastname);
$user->addChild('firstname', $firstname);
$user->addChild('password', $password);
$user->addChild('phone_no', $phone_no);

$increment->customer_id = $increment->customer_id + 1;

$increment->asXML("increment.xml");
$xml->asXML("customer.xml");
?>