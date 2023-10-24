<?php
session_start();
echo $_SESSION[$_POST["type"]];
unset($_SESSION[$_POST["type"]]);
?>