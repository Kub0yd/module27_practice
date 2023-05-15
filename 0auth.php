<?php
require_once 'app/heandlers/functions.php';
require_once 'app/heandlers/rolemanager.php';
//vk authorization
// Параметры приложения
session_start();
$clientId     = "51624420"; // ID приложения

$clientSecret = 'S4iTqXVQ2chUHeTsPs8T'; // Защищённый ключ

$redirectUri  = 'http://localhost/module27_practice/0auth.php'; // Адрес, на который будет переадресован пользователь после прохождения авторизации
$params = array(
    'client_id'     => $clientId,
    'client_secret' => $clientSecret,
    'redirect_uri'  => $redirectUri,
    'code'          => $_GET['code']
);

if (!$content = @file_get_contents('https://oauth.vk.com/access_token?' . http_build_query($params))) {
    $error = error_get_last();
    throw new Exception('HTTP request failed. Error: ' . $error['message']);
}

$response = json_decode($content);

// Если при получении токена произошла ошибка
if (isset($response->error)) {
    throw new Exception('При получении токена произошла ошибка. Error: ' . $response->error . '. Error description: ' . $response->error_description);
}
//А вот здесь выполняем код, если все прошло хорошо
$token = $response->access_token; // Токен
$expiresIn = $response->expires_in; // Время жизни токена
$userId = $response->user_id; // ID авторизовавшегося пользователя
// echo var_dump($response);
// Сохраняем токен в сессии
$_SESSION['vk_token'] = $token;
if (isset($_SESSION['vk_token'])){
    $_SESSION['auth'] =true;

    $db = DbConn::connect();
    $rolemanager = new UserRoleManager($db);
    $handler = new Functions($db);

    $query = $db->query("SELECT id FROM vk_users WHERE user_id=$userId");
    if($query->rowCount() < 1){

        $stmt = $db->prepare("INSERT INTO vk_users (user_id, token) VALUES ($userId, '$token')");
        $stmt -> execute();
        $vkUser = $handler->getVkUser($userId);
        $defaultRoleId = $rolemanager->getRoleId("vk_user");

        $rolemanager->assignRole(NULL, $rolemanager->getRoleId("vk_user"), $vkUser['id']); 
    }
    
    
    

}
header("Location: ./index.php");


// header("Location: ./index.php");
?>
