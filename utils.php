<?php
function HashPassword($password)
{
    $password = hash("sha1", strtoupper($_POST["password"]), true);
    $res = strtoupper(bin2hex($password));

    return $res;
}
function isCustomer()
{
    session_start();
    if (isset($_SESSION["customer"])) {
        return true;
    }
    return false;
}
function isManager()
{
    session_start();
    if (isset($_SESSION["manager"])) {
        return true;
    }
    return false;
}
?>