<?php
require_once 'app/heandlers/functions.php';
// require_once 'app/models/db_conf.php';
// include './app/models/db_conf.php';
class Controller_Login extends Controller {

    function action_index(){

      $auth = $_SESSION['auth'] ?? null;
      if ($auth) {
          header("Location: ./index.php?url=auth");
          exit();
      }
        //Авторизация VK
        // Параметры приложения
        // $clientId     = '51639289'; // ID приложения
        $clientId     = '51624420'; // ID приложения
        // $clientId     = '51639321'; // ID приложения 3
        // $clientSecret = 'fAApz32aq1tMEoWXe9jd'; // Защищённый ключ
        $clientSecret = 'S4iTqXVQ2chUHeTsPs8T'; // Защищённый ключ testapi
        // $clientSecret = 'sVBvJ0uphHYNpCzgqIxx'; // Защищённый ключ 3
        // $redirectUri  = 'https://kubtech.ru/oauth.php'; // Адрес, на который будет переадресован пользователь после прохождения авторизации
        $redirectUri  = 'http://localhost/module27_practice/0auth.php';
        // Формируем ссылку для авторизации
        $data = array(
          'client_id'     => $clientId,
          'redirect_uri'  => $redirectUri,
          'response_type' => 'code',
          'v'             => '5.126', // (обязательный параметр) версиb API https://vk.com/dev/versions
        
          // Права доступа приложения https://vk.com/dev/permissions
          // Если указать "offline", полученный access_token будет "вечным" (токен умрёт, если пользователь сменит свой пароль или удалит приложение).
          // Если не указать "offline", то полученный токен будет жить 12 часов.
          'scope'         => 'photo,offline',
        );
        
        $this->view->generate('login_view.php', 'template_view.php', $data);

        $db = DbConn::connect();
        $heandler = new Functions($db);
        // $auth = $_SESSION['auth'] ?? null;
        // if ($auth) {
        //     header("Location: ./");
        // }
        if (isset($_POST["login"])){
            //сравниваем введенный пароль, и пароль в бд
           $login = $_POST['username'];
           $password = $_POST['password'];
          
           if(password_verify($password, $heandler->getUserPassword($login)))
           {
             // Генерируем случайное число и шифруем его
             $hash = md5($heandler->generateCode(10));
            
             // Записываем в БД новый хеш авторизации и IP
             $db->query("UPDATE users SET user_hash='".$hash."' WHERE id='".$heandler->getUserId($login, $db)."'"); 

             // Ставим куки
             if ((isset($_POST["saveCookie"])))
             {
              echo "<script>alert(\"POST COOKIE\");</script>";
               setcookie("id", $heandler->getUserId($login, $db), time()+60*60*24*30, "/");
               setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true); // httponly !!! 
               // Переадресовываем браузер на страницу проверки нашего скрипта
               //$_SESSION['auth'] = true; 
              //  header("Location: ./index.php");
             }else {
              echo "<script>alert(\"HASH\");</script>";
              //  setcookie("id", getUserId($login), mktime(0), "/");
              //  setcookie("hash", $hash, mktime(0), "/", null, null, true); // httponly !!! 
               // Переадресовываем браузер на страницу проверки нашего скрипта
               $_SESSION['hash'] = $heandler->getUserHash($login, $db);
              //  header("Location: ./index.php");
             }    
             
             header("Location: ./index.php?url=auth"); 
            }else
             {   
               echo "<script>alert(\"Вы ввели неправильный логин/пароль!\");</script>";
             } 
          }
          
    }
}