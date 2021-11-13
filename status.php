<?php
session_start();
require "function.php";
parse_str($_SERVER['QUERY_STRING'], $id_from_link); // получаю массив где будет храниться id пользователя, чей профиль редактируем
$id = $id_from_link['id'];
$status = $_POST['status'];

set_status($id, $status);
set_flash_message("success", "Статус пользователя успешно изменен.");
redirect_to("page_profile.php?id=".$id);
exit;
?>