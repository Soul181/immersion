<?php
session_start();
require "function.php";

$path = 'img/demo/avatars/';        // задаю расположение папки с картинками 
$style_link = $path.$_FILES['picture']['name']; // получаю полный путь с именем картинки

get_image_by_link($style_link); // функция проверки наличия такого имени картинки	
upload_image($style_link);
edit_link_image($style_link);

set_message("success", "Аватар пользователя успешно изменен.");
redirect_to("page_profile.php?id=".$_SESSION['profile_id']);
exit;
?>