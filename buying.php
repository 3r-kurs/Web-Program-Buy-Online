<?php
include("utils.php");

if (!isCustomer()) {
    http_response_code(401);
    die("unauthorized");
}
$xmlFile = file_get_contents("data/goods.xml");
$xml = simplexml_load_string($xmlFile);

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
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
        break;
    case "POST":
        if (empty($_POST["id"])) {
            http_response_code(400);
            die("id is required");
        }
        if (empty($_POST["operation"])) {
            http_response_code(400);
            die("operation is required");
        }
        $id = $_POST["id"];
        $operation = $_POST["operation"];
        $found = false;
        for ($i = 0; $i < $xml->count(); $i++) {
            if ($xml->product[$i]->id != $id) {
                continue;
            }
            if ($operation == "add") {
                if ($xml->product[$i]->quantity <= 0) {
                    http_response_code(500);
                    die("Cannot add more of this item!");
                }
                $xml->product[$i]->quantity = (int) $xml->product[$i]->quantity - 1;
                $xml->product[$i]->on_hold = (int) $xml->product[$i]->on_hold + 1;
            } else {
                if ($xml->product[$i]->on_hold <= 0) {
                    http_response_code(500);
                    die("Cannot remove any more of this item!");
                }
                $xml->product[$i]->quantity = (int) $xml->product[$i]->quantity + 1;
                $xml->product[$i]->on_hold = (int) $xml->product[$i]->on_hold - 1;
            }
        }

        $xml->asXML("data/goods.xml");
        break;
}
?>