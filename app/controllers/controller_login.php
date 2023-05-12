<?php
// include './app/config.php';
class Controller_Login extends Controller {

    function action_index($db){
        $this->view->generate('login_view.php', 'template_view.php');

        // session_start();
        $auth = $_SESSION['auth'] ?? null;
        if ($auth) {
            header("Location: ./");
        }
        if (isset($_POST["login"])){
            //сравниваем введенный пароль, и пароль в бд
           $login = $_POST['username'];
           $password = $_POST['password'];
          
           if(password_verify($password, getUserPassword($login)))
           {
             // Генерируем случайное число и шифруем его
             $hash = md5(generateCode(10));
            
             // Записываем в БД новый хеш авторизации и IP
             $db->query("UPDATE users SET user_hash='".$hash."' WHERE id='".getUserId($login)."'"); 

             // Ставим куки
             if ((isset($_POST["saveCookie"])))
             {
               setcookie("id", getUserId($login), time()+60*60*24*30, "/");
               setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true); // httponly !!! 
               // Переадресовываем браузер на страницу проверки нашего скрипта
               //$_SESSION['auth'] = true; 
              //  header("Location: ./index.php");
             }else {
              
              //  setcookie("id", getUserId($login), mktime(0), "/");
              //  setcookie("hash", $hash, mktime(0), "/", null, null, true); // httponly !!! 
               // Переадресовываем браузер на страницу проверки нашего скрипта
               $_SESSION['hash'] = getUserHash($login);
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