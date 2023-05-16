<?php
require_once 'app/heandlers/functions.php';

class Controller_Auth extends Controller {

    function action_index(){

        
        //подключаем БД и обработчики
        $db = DbConn::connect();
        $heandler = new Functions($db);
        //проверяем пришедшие со страницы аутентификации куки
        if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
            //получаем информацию о юзере через id
            $userId = $_COOKIE['id'];
            $userData =  $heandler->getUserById($userId);
            
            //если хэш или id не совпадают, стираем все куки и сессии
            if (($userData['user_hash'] !== $_COOKIE['hash']) or ($userData['id'] !== $_COOKIE['id'])) {

                echo "<script>alert(\"Что-то пошло не так с авторизацией.. Попробуйте повторить вход\");</script>";
                $heandler->unsetAll();        
            }else{
                $_SESSION['auth']  = true;
            }
        }else if (isset($_SESSION['hash'])) {
            //если находит юзера по хэшу - авторизируемся
            $userDataByHash =  $heandler->getUserByHash($_SESSION['hash']);

            if(!($userDataByHash['login'])){

            echo "<script>alert(\"Что-то пошло не так с авторизацией.. Попробуйте повторить вход\");</script>";
    
            }else {
                    //ставим отметку авторизованного пользователя
                    $_SESSION['auth']  = true;
                    //echo $userId;

            }
        }
        //если авторизация не прошла - переадресовываем на основную страницу
        $auth = $_SESSION['auth'] ?? null;
        if (!$auth) {
            header("Location: ./index.php");
            exit();
        }

        $this->view->generate('auth_view.php', 'template_view.php');
    }
}