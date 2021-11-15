<?php 
session_start();

// функция возвращает всю информацию по юзеру, если такой email есть в базе
function get_user_by_email($email){
	$connect = @mysqli_connect("localhost", "root", "root", "immersion"); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	$sql = "SELECT * FROM `users` WHERE `email`='$email'"; //формируем команду найти совпадение в БД
	$result = mysqli_query($connect, $sql); // отправляем команду в БД
	$user = mysqli_fetch_array($result); // получаем ответ из БД, есть совпадение, или нет
	return $user;
}

// добавление пользователя и возвращение информации по нему, нам нужен id
function add_user($email, $password){
	$connect = @mysqli_connect("localhost", "root", "root", "immersion"); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	$password_hash = password_hash($password, PASSWORD_DEFAULT);
	$sql = "INSERT INTO `users`(`email`, `password`, `role`) VALUES ('$email','$password_hash','user')";// Запрос на запись в БД
	$result = mysqli_query($connect, $sql); // отправляем команду в БД на запись
	$user = get_user_by_email($email); // получаю информацию по только что добавленному юзеру, нужен id
	return $user;						   // возвращает $user 
}

// подготовка сообщения, записываем в сессию
function set_flash_message($name, $message){
	$_SESSION[$name] = $message;
}

// перенаправлние по указанному url
function redirect_to($url){
	header('Location: '.$url);
	exit;
}

// вывести сообщение
function display_flash_message($name){
	if (isset($_SESSION[$name])){
	echo "<div class=\"alert alert-".$name." text-dark\" role=\"alert\"> ".$_SESSION[$name]."</div>";
	unset($_SESSION[$name]);
	}
}

// функция авторизации
function login($email, $password){
	$connect = @mysqli_connect("localhost", "root", "root", "immersion"); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки	
	$sql = "SELECT * FROM `users` WHERE `email`='$email'"; //формируем команду найти совпадение в БД
	$result = mysqli_query($connect, $sql); // отправляем команду в БД
	$user = mysqli_fetch_array($result); // получаем ответ из БД, есть совпадение, или нет

	if($user){
		if(password_verify($password, $user['password'])){
			$_SESSION['user'] = $user;
			return TRUE;
		}
	}
	return FALSE;	
}

// функция очистка сессии от авторизационных данных пользователя
function logout(){
	session_unset();
	redirect_to($url="page_login.php");
	exit;
}

// редактирование общей информации
function edit_information($id, $user_name, $user_job, $user_phone, $adress){
	$connect = @mysqli_connect("localhost", "root", "root", "immersion"); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	//$sql = "INSERT INTO `users`(`user_name`, `user_job`, `user_phone`, `adress`) VALUES ('$user_name', '$user_job', '$user_phone', '$adress') WHERE `id` = '$id'";// Запрос на запись в БД
	$sql = "UPDATE `users` SET `user_name` = '$user_name', `user_job` = '$user_job', `user_phone` = '$user_phone', `adress` = '$adress' WHERE `id` = '$id'"; //  Запрос на запись в БД
	$result = mysqli_query($connect, $sql); // отправляем команду в БД на запись
}

// функция установить статус
function set_status($id, $status){
	$connect = @mysqli_connect("localhost", "root", "root", "immersion"); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	$sql = "UPDATE `users` SET `status` = '$status' WHERE `id` = '$id'"; // Запрос на обновление
	$result = mysqli_query($connect, $sql); // отправляем команду в БД на запись
}

// функция проверяет, есть ли у юзера аватар, если нет, то ставит дефолтный
function has_avatar($id){
	$user = get_user_by_id($id);
	$path = "img/demo/avatars/"; // задаю расположение папки с картинками на сервере, менять только в этом месте
	$default_avatar = "no-image.png"; // аватар, который устновится по умолчанию, если нет другого
	$avatar = $path.$default_avatar; // полный путь
	if (!$user['avatar']){ // если нет, то устанавливаем дефолтную
		// теперь записываем полный путь + имя в базу
		$sql = "UPDATE `users` SET `avatar` = '$avatar' WHERE `id` = '$id'"; // Запрос на обновление
		$result = mysqli_query($connect, $sql); // отправляем команду в БД на запись
		}
}

// функция добавления аватарки
function upload_avatar($id, $avatar){
	// проверяю, есть ли уже аватар по этому id
	$user = get_user_by_id($id);
	// проверяю имя и расширение полученного аватара, установленного ранее
	$path_parts = pathinfo($image['avatar']);
	$name_avatar = $path_parts['basename'];
	$path = 'img/demo/avatars/'; // задаю расположение папки с картинками на сервере, менять только в этом месте
	$default_avatar = "no-image.png"; // аватар, который устновится по умолчанию, если нет другого
	// если картинка уже есть и это не дефолтная картинка, то удаляем ее
	if ($name_avatar != $default_avatar){ // если картинка была, и это не дефолтная, то удаляем, дефолтную не удаляем
		unlink($user['avatar']); // удалить старую картинку 
	}
	if ($_FILES['picture']['tmp_name']){ // если картинка была выбрана для загрузки, то загружаем аватар
		// подготавливаю новое имя для картинки
		$path_parts = pathinfo($_FILES['picture']['name']); // получаем путь, имя файла с расширением
		$extension = $path_parts['extension']; // получаем от него только расширение
		$new_avatar_name = uniqid(); // уникальная 13 значная строка
		$avatar = $path.$new_avatar_name.".".$extension; // новое уникальное имя файла с расширением
		move_uploaded_file($_FILES['picture']['tmp_name'], $avatar); // перемещает загруженый файл в новое место с новым именем
		// теперь записываем полный путь + имя в базу
		$sql = "UPDATE `users` SET `avatar` = '$avatar' WHERE `id` = '$id'"; // Запрос на обновление
		$result = mysqli_query($connect, $sql); // отправляем команду в БД на запись
	}
}

// функция добавления ссылок на социальные сети
function add_social_links($id, $vk_link, $telegram_link, $instagram_link){
	$connect = @mysqli_connect("localhost", "root", "root", "immersion"); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	$sql = "UPDATE `users` SET `vk_link` = '$vk_link', `telegram_link` = '$telegram_link', `instagram_link` = '$instagram_link' WHERE `id` = '$id'"; //  Запрос на запись в БД
	$result = mysqli_query($connect, $sql); // отправляем команду в БД на запись
}

// получаю всю данные о пользователе по конкретному id, полученному методом GET
function get_user_by_id($id){
	$connect = @mysqli_connect("localhost", "root", "root", "immersion"); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	$sql = "SELECT * FROM `users` WHERE `id` = '$id'"; //формируем команду найти совпадение в БД
	$result = mysqli_query($connect, $sql); // отправляем команду в БД
	$user = mysqli_fetch_array($result);
	return $user;
}

// проверка своего аккаунта
function is_author($id){
	if ($_SESSION['user']['id'] != $id){ // если редактирую не свой профиль, то FALSE
		if ($_SESSION['user']['role'] != "admin"){
		return FALSE;
		}
	}
	return TRUE;
}

// функция редактирования email и password
function edit_credentials($id, $email, $password){
	$connect = @mysqli_connect("localhost", "root", "root", "immersion"); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	$password_hash = password_hash($password, PASSWORD_DEFAULT);
	$sql = "UPDATE `users` SET `email` = '$email', `password` = '$password_hash' WHERE `id` = '$id'"; //  Запрос на запись в БД
	$result = mysqli_query($connect, $sql); // отправляем команду в БД на запись
}

// функия удаления пользователя
function delete_user($id){
	$connect = @mysqli_connect("localhost", "root", "root", "immersion"); // Соединяемся с базой
	mysqli_set_charset($connect, "utf8"); // установка кодировки
	$sql = "SELECT `avatar` FROM `users` WHERE `id`='$id'"; //формируем команду найти совпадение в БД
	$result = mysqli_query($connect, $sql); // отправляем команду в БД
	$image = mysqli_fetch_array($result); // получаем ответ из БД, есть совпадение, или нет
	if ($image['avatar'] != NULL){
	unlink($image['avatar']); // удалить картинку 
	}
	$sql = "DELETE FROM `users` WHERE `id` = '$id'"; // Запрос на обновление
	$result = mysqli_query($connect, $sql); // отправляем команду в БД на запись
	return true;
}

?>