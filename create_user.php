<?php 
session_start();
require "function.php";

if ($_POST['status'] == "Онлайн") {$status = "success";}
if ($_POST['status'] == "Отошел") {$status = "warning";}
if ($_POST['status'] == "Не беспокоить") {$status = "danger";}
$user_name = $_POST['user_name'];
$user_job = $_POST['user_job'];
$user_phone = $_POST['user_phone'];
$email = $_POST['email'];
$password = $_POST['password'];
$adress = $_POST['adress'];
$vk_link = $_POST['vk_link'];
$telegram_link = $_POST['telegram_link'];
$instagram_link = $_POST['instagram_link'];
$avatar = $_FILES['picture']['name'];

$user = get_user_by_email($email); // проверка на наличие совпадения по email

if ($user){ // если email уже есть, то вывод сообщения
	set_flash_message("danger", "Этот эл. адрес уже занят другим пользователем.");
	redirect_to("page_create_user.php");
	return false;
} else { // если email свободен, то создаем нового пользователя
	$user = add_user($email, $password); // запись трёх полей, email, password, role, возвращение созданного id
	$id = $user['id'];
	edit_information($id, $user_name, $user_job, $user_phone, $adress); // запись в таблицу $user_name, $user_job, $user_phone, $adress по переданному id
	set_status($id, $status); // установка статуса
	upload_avatar($id, $avatar); // загрузка аватара
	add_social_links($id, $vk_link, $telegram_link, $instagram_link); // добавление ссылок на соц сети
	set_flash_message("success", "Новый пользователь успешно добавлен.");
	redirect_to("page_users.php");
	exit;
}
?>