<?php 
session_start();

function get_info_by_id($id){
	$db_data = ["servername" => "localhost",
				"username" => "root",
				"password" => "root",
				"database" => "immersion"];
	$connect = @mysqli_connect($db_data["servername"], $db_data["username"], $db_data["password"], $db_data["database"]); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки

	$sql = "SELECT * FROM `base` WHERE `id` = '$id'"; //формируем команду найти совпадение в БД
	$result = mysqli_query($connect, $sql); // отправляем команду в БД
	$user = mysqli_fetch_array($result);
	return $user;
}

function get_info_by_admin(){
	$db_data = ["servername" => "localhost",
				"username" => "root",
				"password" => "root",
				"database" => "immersion"];
	$connect = @mysqli_connect($db_data["servername"], $db_data["username"], $db_data["password"], $db_data["database"]); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки

	$sql = "SELECT * FROM `base` WHERE `role` = 'admin'"; //формируем команду найти совпадение в БД
	$result = mysqli_query($connect, $sql); // отправляем команду в БД
	$admin = mysqli_fetch_array($result);
	return $admin;
}

function get_user_by_email($email){
	$db_data = ["servername" => "localhost",
				"username" => "root",
				"password" => "root",
				"database" => "immersion"];
	$connect = @mysqli_connect($db_data["servername"], $db_data["username"], $db_data["password"], $db_data["database"]); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	
	if ($connect && isset($email)) {
		$sql = "SELECT * FROM `base` WHERE `email`='$email'"; //формируем команду найти совпадение в БД
		$result = mysqli_query($connect, $sql); // отправляем команду в БД
		$user = mysqli_fetch_array($result); // получаем ответ из БД, есть совпадение, или нет
		return $user;
		}
}

function get_image_by_link($style_link) {
	$db_data = ["servername" => "localhost",
				"username" => "root",
				"password" => "root",
				"database" => "immersion"];
	$connect = @mysqli_connect($db_data["servername"], $db_data["username"], $db_data["password"], $db_data["database"]); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	
	if ($connect && isset($style_link)) {
		$sql = "SELECT * FROM `base` WHERE `style_link`='$style_link'"; //формируем команду найти совпадение в БД
		$result = mysqli_query($connect, $sql); // отправляем команду в БД
		$image = mysqli_fetch_array($result); // получаем ответ из БД, есть совпадение, или нет
		return $image;
		}
}

function upload_image($style_link){
		if ($image['style_link'] == $style_link) { // если такое имя уже есть
			set_message("danger", "Такое название картирки уже есть. Измените название");
			return false;
		} else { // ессли имя свободно, то продолжаем
			if ($image == TRUE) { // если картинка была
				if ($image['style_link'] != 'img/demo/avatars/no-image.png') { // удаляем старый файл, если не равен значению по умолчанию
					unlink($image['style_link']); 
				}
				copy($_FILES['picture']['tmp_name'], $style_link); // добавление новой картинки
			} else { // просто добавляем новую
				copy($_FILES['picture']['tmp_name'], $style_link); // добавление новой картинки
			}
		}
}

function edit_link_image($style_link){
	$db_data = ["servername" => "localhost",
				"username" => "root",
				"password" => "root",
				"database" => "immersion"];
	$connect = @mysqli_connect($db_data["servername"], $db_data["username"], $db_data["password"], $db_data["database"]); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	
	$id = $_SESSION['user']['id'];
	$sql = "UPDATE `base` SET `style_link` = '$style_link' WHERE `id` = '$id'"; // Запрос на обновление
	$result = mysqli_query($connect, $sql); // отправляем команду в БД на запись
}

function set_message($name, $message){
	$_SESSION[$name] = $message;
}

function redirect_to($url){
	header('Location: '.$url);
	exit;
}

function add_user($status, $user_name, $style_link, $user_position, $user_phone, $email, $password, $adress, $vk_link, $telegram_link, $instagram_link){
	$db_data = ["servername" => "localhost",
				"username" => "root",
				"password" => "root",
				"database" => "immersion"];
	$connect = @mysqli_connect($db_data["servername"], $db_data["username"], $db_data["password"], $db_data["database"]); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	
	// проверяю, откуда получены данные, если из формы регистрации, то будет только email и password
	// если со страницы добавления пользователя админом, то принимаем все данные
	if (!isset($status) && !isset($user_name) && !isset($style_link) && !isset($user_position) && !isset($user_phone) && !isset($adress) && !isset($vk_link) && !isset($telegram_link) && !isset($instagram_link)) {
		$sql = "INSERT INTO `base`(`status`, `user_name`, `style_link`, `user_position`, `user_phone`,
		`email`, `password`, `role`, `adress`, `vk_link`, `telegram_link`, `instagram_link`) VALUES ('-','-',
		'-','-','-','$email','$password','user','-','-','-','-')";// Запрос в БД, Добавляем запись в БД только email и password
	} else {
	$sql = "INSERT INTO `base`(`status`, `user_name`, `style_link`, `user_position`, `user_phone`,
	`email`, `password`, `role`, `adress`, `vk_link`, `telegram_link`, `instagram_link`) VALUES ('$status','$user_name',
	'$style_link','$user_position','$user_phone','$email','$password','user','$adress',
	'$vk_link','$telegram_link','$instagram_link')";// Запрос в БД, Добавляем всё в БД
	}
	$result = mysqli_query($connect, $sql); // отправляем команду в БД на запись
}

function alert_message($name){
	if (isset($_SESSION[$name])){
	echo "<div class=\"alert alert-".$name." text-dark\" role=\"alert\"> ".$_SESSION[$name]."</div>";
	unset($_SESSION[$name]);
	}
}

function login($email, $password){
	$db_data = ["servername" => "localhost",
				"username" => "root",
				"password" => "root",
				"database" => "immersion"];
	$connect = @mysqli_connect($db_data["servername"], $db_data["username"], $db_data["password"], $db_data["database"]); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	
	if ($connect) {
		$sql = "SELECT * FROM `base` WHERE `email`='$email'"; //формируем команду найти совпадение в БД
		$result = mysqli_query($connect, $sql); // отправляем команду в БД
		$user = mysqli_fetch_array($result); // получаем ответ из БД, есть совпадение, или нет
		
		if($user){
			if($user["password"] == $password){
				$_SESSION['user'] = $user;
				return TRUE;
			}
		}
		return FALSE;
		}
}

function unlogin(){
	session_unset();
	redirect_to($url="page_login.php");
	exit;
}

function edit_user_name($user_name){
	$db_data = ["servername" => "localhost",
				"username" => "root",
				"password" => "root",
				"database" => "immersion"];
	$connect = @mysqli_connect($db_data["servername"], $db_data["username"], $db_data["password"], $db_data["database"]); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	
	$id = $_SESSION['user']['id'];
	$sql = "UPDATE `base` SET `user_name` = '$user_name' WHERE `id` = '$id'"; // Запрос на обновление
	$result = mysqli_query($connect, $sql); // отправляем команду в БД на запись
}

function edit_user_position($user_position){
	$db_data = ["servername" => "localhost",
				"username" => "root",
				"password" => "root",
				"database" => "immersion"];
	$connect = @mysqli_connect($db_data["servername"], $db_data["username"], $db_data["password"], $db_data["database"]); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	
	$id = $_SESSION['user']['id'];
	$sql = "UPDATE `base` SET `user_position` = '$user_position' WHERE `id` = '$id'"; // Запрос на обновление
	$result = mysqli_query($connect, $sql); // отправляем команду в БД на запись
}

function edit_user_phone($user_phone){
	$db_data = ["servername" => "localhost",
				"username" => "root",
				"password" => "root",
				"database" => "immersion"];
	$connect = @mysqli_connect($db_data["servername"], $db_data["username"], $db_data["password"], $db_data["database"]); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	
	$id = $_SESSION['user']['id'];
	$sql = "UPDATE `base` SET `user_phone` = '$user_phone' WHERE `id` = '$id'"; // Запрос на обновление
	$result = mysqli_query($connect, $sql); // отправляем команду в БД на запись
}

function edit_adress($adress){
	$db_data = ["servername" => "localhost",
				"username" => "root",
				"password" => "root",
				"database" => "immersion"];
	$connect = @mysqli_connect($db_data["servername"], $db_data["username"], $db_data["password"], $db_data["database"]); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	
	$id = $_SESSION['user']['id'];
	$sql = "UPDATE `base` SET `adress` = '$adress' WHERE `id` = '$id'"; // Запрос на обновление
	$result = mysqli_query($connect, $sql); // отправляем команду в БД на запись
}

function edit_email_password($email, $password){ // id передается в сессии
	$db_data = ["servername" => "localhost",
				"username" => "root",
				"password" => "root",
				"database" => "immersion"];
	$connect = @mysqli_connect($db_data["servername"], $db_data["username"], $db_data["password"], $db_data["database"]); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	
	$id = $_SESSION['profile_id'];
	$sql = "UPDATE `base` SET `email` = '$email', `password` = '$password' WHERE `id` = '$id'"; // Запрос на обновление
	$result = mysqli_query($connect, $sql); // отправляем команду в БД на запись
}

function edit_status($status){ // id передается в сессии
	$db_data = ["servername" => "localhost",
				"username" => "root",
				"password" => "root",
				"database" => "immersion"];
	$connect = @mysqli_connect($db_data["servername"], $db_data["username"], $db_data["password"], $db_data["database"]); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	
	$id = $_SESSION['profile_id'];
	$sql = "UPDATE `base` SET `status` = '$status' WHERE `id` = '$id'"; // Запрос на обновление
	$result = mysqli_query($connect, $sql); // отправляем команду в БД на запись
}

function delete_user(){
	$db_data = ["servername" => "localhost",
				"username" => "root",
				"password" => "root",
				"database" => "immersion"];
	$connect = @mysqli_connect($db_data["servername"], $db_data["username"], $db_data["password"], $db_data["database"]); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	
	$id = $_SESSION['profile_id'];
	$sql = "DELETE FROM `base` WHERE `id` = '$id'"; // Запрос на обновление
	$result = mysqli_query($connect, $sql); // отправляем команду в БД на запись
	return true;
}

?>