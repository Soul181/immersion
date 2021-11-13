<?php
session_start();
require "function.php";
$path = 'img/demo/avatars/'; 
 
parse_str($_SERVER['QUERY_STRING'], $id_from_link); // получаю массив где будет храниться id пользователя, чей профиль редактируем
$id = $id_from_link['id'];

$avatar = $path.$_FILES['picture']['name']; // получаю полный путь с именем картинки

upload_avatar($id, $avatar);

set_flash_message("success", "Аватар пользователя успешно изменен.");
redirect_to("page_profile.php?id=".$id);
exit;
?>