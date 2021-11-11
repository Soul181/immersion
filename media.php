<?php
session_start();
require "function.php";
$path = 'img/demo/avatars/';  

$id = $_SESSION['id_from_link'];
$avatar = $path.$_FILES['picture']['name']; // получаю полный путь с именем картинки

upload_avatar($id, $avatar);

set_flash_message("success", "Аватар пользователя успешно изменен.");
redirect_to("page_profile.php?id=".$_SESSION['id_from_link']);
exit;
?>