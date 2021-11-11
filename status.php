<?php
session_start();
require "function.php";

$status = $_POST['status'];
$id = $_SESSION['id_from_link'];

set_status($id, $status);
set_flash_message("success", "Статус пользователя успешно изменен.");
redirect_to("page_profile.php?id=".$_SESSION['id_from_link']);
exit;
?>