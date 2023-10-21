<?php

include("utils.php");

if (!isManager()) {
    http_response_code(401);
    die("unauthorized");
}

if (!isset($_POST["name"])) {
    http_response_code(400);
    die("name is required");
}
$name = $_POST["name"];
if (!isset($_POST["price"])) {
    http_response_code(400);
    die("price is required");
}
$price = $_POST["price"];
if (!isset($_POST["quantity"])) {
    http_response_code(400);
    die("quantity is required");
}
$quantity = $_POST["quantity"];
if (!isset($_POST["description"])) {
    http_response_code(400);
    die("description is required");
}
$description = $_POST["description"];

$incrementFile = file_get_contents("data/increment.xml");
$increment = simplexml_load_string($incrementFile);

$xmlFile = file_get_contents("data/goods.xml");
$xml = simplexml_load_string($xmlFile);

$product = $xml->addChild('product');
$product->addChild('id', $increment->product_id);
$product->addChild('name', $name);
$product->addChild('description', $description);
$product->addChild('price', $price);
$product->addChild('quantity', $quantity);
$product->addChild('on_hold', 0);
$product->addChild('sold', 0);

$increment->product_id = $increment->product_id + 1;
$increment->asXML("data/increment.xml");
$xml->asXML("data/goods.xml");
echo count($xml);
?>