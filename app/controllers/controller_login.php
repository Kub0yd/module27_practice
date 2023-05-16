<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\HtmlFormatter;

require_once 'app/heandlers/functions.php';

class Controller_Login extends Controller {

    
    function action_index(){
      //переадресация, если пользователь уже авторизован
      $auth = $_SESSION['auth'] ?? null;
      if ($auth) {
          header("Location: ./index.php?url=auth");
          exit();
      }
      //подгружаем данные из модели
      $this->model = new Model_Login();  
      $data = $this->model->get_data();

      $this->view->generate('login_view.php', 'template_view.php', $data);
      //подключаем БД и обработчики
      $db = DbConn::connect();
      $heandler = new Functions($db);

     

      //обработка входа на сайт по логину и паролю
      if (isset($_POST["login"])){
          //сравниваем введенный пароль, и пароль в бд
          $login = $_POST['username'];
          $password = $_POST['password'];
          // Создаем логгер 
          $log = new Logger('mylogger');
          // Хендлер, который будет писать логи в "troubles.log" и реагировать на ошибки с уровнем "ALERT" и выше.
          $log->pushHandler(new StreamHandler('troubles.log', Logger::ALERT));
          if(password_verify($password, $heandler->getUserPassword($login)))
          {
            // Генерируем случайное число и шифруем его
            $hash = md5($heandler->generateCode(10));
          
            // Записываем в БД новый хеш авторизации
            $db->query("UPDATE users SET user_hash='".$hash."' WHERE id='".$heandler->getUserId($login)."'"); 

            // Ставим куки, если пользователь захотел
            if ((isset($_POST["saveCookie"])))
            {
              setcookie("id", $heandler->getUserId($login), time()+60*60*24*30, "/");
              setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true); // httponly !!! 
            }else {
              //если не ставим куки, то записываем токен в сессию
              $_SESSION['hash'] = $heandler->getUserHash($login);

            }    
            //после успешного входа адресуем на страницу с контентом
            header("Location: ./index.php?url=auth"); 
          }else
            { 
              //если ошибка со входом - предупреждаем пользователя и пишем в лог  
              echo "<script>alert(\"Вы ввели неправильный логин/пароль!\");</script>";
              $log->alert('Ошибка входа, неправильный пароль', [$login]);
            } 
        }
          
    }
}