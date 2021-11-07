<?php
session_start();
require "function.php";
parse_str($_SERVER['QUERY_STRING'], $profile_id);
$id = $profile_id['id'];

if (!isset($_SESSION['user'])){ // проверка, НЕ авторизован ли пользователь
	redirect_to("page_login.php");
	exit;
}	

if ($_SESSION['user']['role'] != "admin" && $_SESSION['user']['id'] != $id){ // проверка, НЕ авторизован ли пользователь, редактирую свой аккаунт?
	set_message("danger", "Ошибка! Удалять можно только свой профиль!");
	redirect_to("page_users.php");
	return false;
}	

if ($_SESSION['user']['role'] == "admin"){ // проверка, админ ли это
	$_SESSION['profile_id'] = $id;
	} else {
		$_SESSION['profile_id'] = $_SESSION['user']['id'];
	}

$delete_user = delete_user();
if ($delete_user == TRUE){
	if ($_SESSION['user']['role'] != "admin") {
		unlogin();
		} else {
			set_message("success", "Удаление пользователя успешно.");
			redirect_to("page_users.php");
		}
} else {
	set_message("danger", "Удаление пользователя завершилось ошибкой.");
	redirect_to("page_users.php");
	exit;
}
?>
