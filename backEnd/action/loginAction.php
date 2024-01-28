<?php

require_once "../service/UserService.php";

$service = new UserService();
$service->login($_POST["email"], $_POST["mp"]);
