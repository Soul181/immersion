<?php
session_start();
require "function.php";
parse_str($_SERVER['QUERY_STRING'], $id_from_link); // получаю массив где будет храниться id пользователя, чей профиль редактируем
$id = $id_from_link['id'];

$user_name = $_POST['user_name'];
$user_job = $_POST['user_job'];
$user_phone = $_POST['user_phone'];
$adress = $_POST['adress'];

edit_information($id, $user_name, $user_job, $user_phone, $adress);
set_flash_message("success", "Профиль пользователя успешно изменен.");
redirect_to("page_users.php");
exit;
?>