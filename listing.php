<?php

include("utils.php");

if (CheckLogin()) {
    http_response_code(401);
    die("unauthorized");
}
?>