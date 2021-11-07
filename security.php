<?php
session_start();
require "function.php";

$email = $_POST['email'];
$password = $_POST['password'];
$password_confirmation = $_POST['password_confirmation'];

$user = get_user_by_email($email); // проверка на наличие совпадения по email
if ($password == "" || $password_confirmation == ""){
	set_message("danger", "Введите пароль");
	redirect_to("page_security.php?id=".$_SESSION['profile_id']);
	return false;	
} else {
	if ($user == TRUE && $email != $_SESSION['user']['email']) {
		set_message("danger", "Этот эл. адрес уже занят другим пользователем.");
		redirect_to("page_security.php?id=".$_SESSION['profile_id']);
		return false;	
	} else { // такого email нет, менять можно, либо я меняю свой же имейл на тот что был
		if ($password != $password_confirmation && $password == "" && $password_confirmation == ""){
			set_message("danger", "Пароли не совпадают.");
			redirect_to("page_security.php?id=".$_SESSION['profile_id']);
			return false;
		} else {
			$admin = get_info_by_admin();
			edit_email_password($email, $password);
			set_message("success", "Email и пароль пользователя успешно изменены.");
			// если я не админ, редактирую свой email, то и в сессии вверху страницы изменить на новый email
			// если я админ, и редактирую НЕ СВОЙ профиль, то email сессии вверху страницы НЕ МЕНЯЮ
			// если я админ, и меняю СВОЙ email, то и в сессии вверху страницы изменить на новый email
			if ($_SESSION['user']['role'] != "admin" || $_SESSION['user']['role'] == "admin" && $_SESSION['profile_id'] == $admin['id']) {
				$_SESSION['user']['email'] = $email;
				}
			redirect_to("page_profile.php?id=".$_SESSION['profile_id']);
			exit;
			}
	}
}
?>