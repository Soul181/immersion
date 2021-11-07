<?php 
session_start();
require "function.php";

if ($_POST['status'] == "Онлайн") {$status = "success";}
if ($_POST['status'] == "Отошел") {$status = "warning";}
if ($_POST['status'] == "Не беспокоить") {$status = "danger";}
$user_name = $_POST['user_name'];
$user_position = $_POST['user_position'];
$user_phone = $_POST['user_phone'];
$email = $_POST['email'];
$password = $_POST['password'];
$adress = $_POST['adress'];
$vk_link = $_POST['vk_link'];
$telegram_link = $_POST['telegram_link'];
$instagram_link = $_POST['instagram_link'];
$path = 'img/demo/avatars/';        // задаю расположение папки с картинками 
$style_link = $path.$_FILES['picture']['name']; // получаю полный путь с именем картинки

$user = get_user_by_email($email); // проверка на наличие совпадения по email

if ($user == TRUE){
	set_message("danger", "Этот эл. адрес уже занят другим пользователем.");
	redirect_to("page_create_user.php");
	return false;
} else { // такого email нет
	get_image_by_link($style_link); // функция проверки наличия такого имени картинки	
	upload_image($style_link);
	add_user($status, $user_name, $style_link, $user_position, $user_phone, $email, $password, $adress, $vk_link, $telegram_link, $instagram_link);
	set_message("success", "Новый пользователь успешно добавлен.");
	redirect_to("page_users.php");
	exit;
}
?>