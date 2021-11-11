<?php
session_start();
require "function.php";

// id_from_link переданый id через GET

$email = $_POST['email'];
$password = $_POST['password'];
$password_hash = password_hash($password, PASSWORD_DEFAULT);
$password_confirmation = $_POST['password_confirmation'];
$password_confirmation_hash = password_hash($password_confirmation, PASSWORD_DEFAULT);


$user = get_user_by_email($email); // проверка на наличие совпадения по email
if ($password == "" || $password_confirmation == "" || $password == "" && $password_confirmation == ""){ // проверка если какой-то из паролей забыли ввести
	set_flash_message("danger", "Введите пароль");
	redirect_to("page_security.php?id=".$_SESSION['id_from_link']);
	return false;	
} else {
	if ($user == TRUE && $email != $_SESSION['user']['email']) {
		set_flash_message("danger", "Этот эл. адрес уже занят другим пользователем.");
		redirect_to("page_security.php?id=".$_SESSION['id_from_link']);
		return false;	
	} else { // такого email нет, менять можно, либо я меняю свой же имейл на тот что был
		if ($password != $password_confirmation){ // если пароли не равны
			set_flash_message("danger", "Пароли не совпадают.");
			redirect_to("page_security.php?id=".$_SESSION['id_from_link']);
			return false;
		} else { // теперь можно редактировать
			// $_SESSION['id_from_link'] это наш id по которому нужно редактировать данные
			edit_credentials($email, $password);
			set_flash_message("success", "Email и пароль пользователя успешно изменены.");
			// если я не админ, редактирую свой email, то и в сессии вверху страницы изменить на новый email
			// если я админ, и меняю СВОЙ email, то и в сессии вверху страницы изменить на новый email
			// если я админ, и редактирую НЕ СВОЙ профиль, то email сессии вверху страницы НЕ МЕНЯЮ
			if ($_SESSION['user']['role'] != "admin" || $_SESSION['user']['role'] == "admin" && $_SESSION['id_from_link'] == $_SESSION['user']['id']) {
				$_SESSION['user']['email'] = $email;
				}
			redirect_to("page_profile.php?id=".$_SESSION['id_from_link']);
			exit;
			}
	}
}
?>