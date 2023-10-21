<?php
include("utils.php");

if (!isset($_GET["type"])) {
    http_response_code(400);
    die("type is required");
}
$type = $_GET["type"];

if (($type == "buying" && !isCustomer()) || ($type == "processing" && !isManager())) {
    http_response_code(401);
    die("unauthorized");
}

$xmlFile = file_get_contents("data/goods.xml");
$xml = simplexml_load_string($xmlFile);
$response = array();
for ($i = 0; $i < $xml->count(); $i++) {
    $product = $xml->product[$i];
    $item = new stdClass();
    $item->id = (int) $product->id;
    $item->name = (string) $product->name;
    $item->description = (string) $product->description;
    $item->price = (int) $product->price;
    $item->quantity = (int) $product->quantity;
    $item->on_hold = (int) $product->on_hold;
    $item->sold = (int) $product->sold;
    if ($type == "buying" && $item->quantity == 0) {
        continue;
    }
    if ($type == "processing" && $item->sold == 0) {
        continue;
    }
    array_push($response, $item);
}
echo json_encode($response);
?>