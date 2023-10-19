<?php

include("utils.php");

if (empty($_POST["email"])) {
    echo "email is required";
    http_response_code(400);
    exit();
}
if (empty($_POST["lastname"])) {
    echo "lastname is required";
    http_response_code(400);
    exit();
}
if (empty($_POST["firstname"])) {
    echo "firstname is required";
    http_response_code(400);
    exit();
}
if (empty($_POST["password"])) {
    echo "password is required";
    http_response_code(400);
    exit();
}

$email = $_POST["email"];
$lastname = $_POST["lastname"];
$firstname = $_POST["firstname"];
$password = EncryptPassword($_POST["password"]);
$phone_no = isset($_POST["phone_no"]) ? $_POST["phone_no"] : '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "invalid email address";
    http_response_code(400);
    exit();
}

$xmlFile = file_get_contents("customer.xml");
$xml = simplexml_load_string($xmlFile);

for ($i = 0; $i < $xml->count(); $i++) {
    if ($xml->user[$i]->email == $email) {
        echo "email already exists";
        http_response_code(400);
        exit();
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