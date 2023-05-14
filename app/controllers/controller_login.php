<?php
require_once 'app/models/functions.php';
// require_once 'app/models/db_conf.php';
// include './app/models/db_conf.php';
class Controller_Login extends Controller {

    function action_index(){
        $this->view->generate('login_view.php', 'template_view.php');
        $db = DbConn::connect();
        $auth = $_SESSION['auth'] ?? null;
        if ($auth) {
            header("Location: ./");
        }
        if (isset($_POST["login"])){
            //сравниваем введенный пароль, и пароль в бд
           $login = $_POST['username'];
           $password = $_POST['password'];
          
           if(password_verify($password, Functions::getUserPassword($login)))
           {
             // Генерируем случайное число и шифруем его
             $hash = md5(Functions::generateCode(10));
            
             // Записываем в БД новый хеш авторизации и IP
             $db->query("UPDATE users SET user_hash='".$hash."' WHERE id='".Functions::getUserId($login)."'"); 

             // Ставим куки
             if ((isset($_POST["saveCookie"])))
             {
               setcookie("id", Functions::getUserId($login), time()+60*60*24*30, "/");
               setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true); // httponly !!! 
               // Переадресовываем браузер на страницу проверки нашего скрипта
               //$_SESSION['auth'] = true; 
              //  header("Location: ./index.php");
             }else {
              
              //  setcookie("id", getUserId($login), mktime(0), "/");
              //  setcookie("hash", $hash, mktime(0), "/", null, null, true); // httponly !!! 
               // Переадресовываем браузер на страницу проверки нашего скрипта
               $_SESSION['hash'] = Functions::getUserHash($login);
              //  header("Location: ./index.php");
             }    
             
             header("Location: ./index.php");
            }else
             {   
               echo "<script>alert(\"Вы ввели неправильный логин/пароль!\");</script>";
             } 
          } 
    }
}