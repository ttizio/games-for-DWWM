<?php

require_once "../service/UserService.php";

$service = new UserService();
$service->register($_POST["email"], $_POST["mp"], $_POST["mp_confirm"]);
