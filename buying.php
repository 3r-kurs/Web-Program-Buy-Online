<?php
include("utils.php");

if (!isCustomer()) {
    http_response_code(401);
    die("unauthorized");
}


$xmlFile = file_get_contents("buying.xml");
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
    array_push($response, $item);
}
echo json_encode($response);
?>