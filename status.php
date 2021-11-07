<?php
session_start();
require "function.php";

$status = $_POST['status'];

edit_status($status);
set_message("success", "Статус пользователя успешно изменен.");
redirect_to("page_profile.php?id=".$_SESSION['profile_id']);
exit;
?>