<?php 
session_start();
require "function.php";
parse_str($_SERVER['QUERY_STRING'], $id_from_link); // получаю массив где будет храниться id пользователя, чей профиль редактируем
$id = $id_from_link['id'];
$_SESSION['id_from_link'] = $id; // передаю id юзера в edit.php

if (!isset($_SESSION['user'])){ // проверка, НЕ авторизован ли пользователь
	redirect_to("page_login.php");
	exit;
}	

if (!is_author()){
	set_flash_message("danger", "Ошибка! Удалять можно только свой профиль!");
	redirect_to("page_users.php");
	exit;
}

$delete_user = delete_user();
if ($delete_user == TRUE){
	if ($_SESSION['user']['role'] != "admin") {
		logout();
		set_flash_message("success", "Удаление пользователя успешно.");
		redirect_to("page_login.php");
		} else {
			set_flash_message("success", "Удаление пользователя успешно.");
			redirect_to("page_users.php");
		}
} else {
	set_flash_message("danger", "Удаление пользователя завершилось ошибкой.");
	redirect_to("page_users.php");
	exit;
}
?>
