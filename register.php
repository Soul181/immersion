<?php
session_start();
require "function.php";

$email = $_POST['email'];
$password = $_POST['password'];

$user = get_user_by_email($email);

if ($user == TRUE) {
	set_message("danger", "Этот эл. адрес уже занят другим пользователем.");
	redirect_to("page_register.php");
} 
else {
	add_user($email, $password);
	set_message("success", "Регистрация успешно завершена.");
	redirect_to("page_login.php");
	exit;	
} 
?> 