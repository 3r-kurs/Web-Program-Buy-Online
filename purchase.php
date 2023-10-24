<?php
include("utils.php");

if (!isCustomer()) {
    http_response_code(401);
    die("unauthorized");
}

if (empty($_POST["service"])) {
    http_response_code(400);
    die("service is required");
}

$items = isset($_POST["items"]) ? $_POST["items"] : [];

$service = $_POST["service"];

$xmlFile = file_get_contents("data/goods.xml");
$xml = simplexml_load_string($xmlFile);

$result = 0;

for ($i = 0; $i < count($xml); $i++) {
    $product = $xml->product[$i];
    for ($j = 0; $j < count($items); $j++) {
        if ($product->id == $items[$j]["id"]) {
            $xml->product[$i]->on_hold -= $items[$j]["count"];
            if ($service == "purchase") {
                $xml->product[$i]->sold += $items[$j]["count"];
                $result += $product->price * $items[$j]["count"];
            }
            if ($service == "cancel") {
                $xml->product[$i]->quantity += $items[$j]["count"];
            }
        }
    }
}

$xml->asXML("data/goods.xml");
if ($service == "purchase") {
    echo $result;
}
?>