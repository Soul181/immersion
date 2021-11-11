<?php
session_start();
require "function.php";

$email = $_POST['email'];
$password = $_POST['password'];

$login = login($email, $password);

if (!$login) {
	set_flash_message("danger", "E-mail или пароль указаны неверно. Проверьте правильность написания.");
	redirect_to("page_login.php");
	exit;
} 
else {
	redirect_to("page_users.php");
	exit;
} 
?>