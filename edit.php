<?php
session_start();
require "function.php";

$user_name = $_POST['user_name'];
$user_position = $_POST['user_position'];
$user_phone = $_POST['user_phone'];
$adress = $_POST['adress'];

edit_user_name($user_name);
edit_user_position($user_position);
edit_user_phone($user_phone);
edit_adress($adress);

set_message("success", "Профиль пользователя успешно изменен.");
redirect_to("page_users.php");
exit;

?>