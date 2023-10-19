<?php
function EncryptPassword($password)
{
    $password = hash("sha1", strtoupper($_POST["password"]), true);
    $res = strtoupper(bin2hex($password));

    return $res;
}
function LoggedIn()
{
    session_start();
    if (isset($_SESSION["loginSession"])) {
        return true;
    }
    return false;
}
?>