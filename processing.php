<?php

include("utils.php");

if (!isManager()) {
    http_response_code(401);
    die("unauthorized");
}

$xmlFile = file_get_contents("data/goods.xml");
$xml = simplexml_load_string($xmlFile);
switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        $response = array();
        for ($i = 0; $i < $xml->count(); $i++) {
            $product = $xml->product[$i];
            $item = new stdClass();
            $item->id = (int) $product->id;
            $item->name = (string) $product->name;
            $item->price = (int) $product->price;
            $item->quantity = (int) $product->quantity;
            $item->on_hold = (int) $product->on_hold;
            $item->sold = (int) $product->sold;
            if ($item->sold == 0) {
                continue;
            }
            array_push($response, $item);
        }
        echo json_encode($response);
        break;
    case 'POST':
        for ($i = 0; $i < $xml->count(); $i++) {
            if ($xml->product[$i]->quantity == 0) {
                unset($xml->product[$i]);
                continue;
            }
            $xml->product[$i]->sold = 0;
        }
        $xml->asXML("data/goods.xml");
        break;
    default:
        http_response_code(404);
        break;
}
?>