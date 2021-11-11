<?php
$dot_1 = "admin";
$dot_2 = "ab99";

$password_1 = password_hash($dot_1, PASSWORD_DEFAULT);

$password_2 = password_hash($dot_2, PASSWORD_DEFAULT); 

if (password_verify($dot_1, $password_1))
{
	//var_dump($password_1, " >-< ", $password_2);
	echo $password_1;
	exit;
} else {
	var_dump(FALSE);
	exit;
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

?>