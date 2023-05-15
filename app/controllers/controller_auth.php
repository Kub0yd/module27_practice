<?php
require_once 'app/heandlers/functions.php';
// require_once 'app/models/db_conf.php';
// include './app/models/db_conf.php';
class Controller_Auth extends Controller {

    function action_index(){

        
        $superUser = false;
        $db = DbConn::connect();
        $heandler = new Functions($db);
        // $userDataByHash = getUserByHash($_SESSION['hash']);
        // echo "<script>alert(\"class\");</script>";
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
                // echo "<script>alert(\"cookie\");</script>";
                //ставим отметку авторизованного пользователя
                // $_SESSION['auth']  = 1;
                $_SESSION['auth']  = true;
                //echo $userId;
            }
        }else if (isset($_SESSION['hash'])) {
            $userDataByHash =  $heandler->getUserByHash($_SESSION['hash']);
            if(!($userDataByHash['login'])){
        // if(!(isset($_SESSION['hash']) and !!($userDataByHash['login']))){
            echo "<script>alert(\"Что-то пошло не так с авторизацией.. Попробуйте повторить вход\");</script>";
            // header('Location: ./index.php?=login');       
            }else {
                    //ставим отметку авторизованного пользователя
                    $_SESSION['auth']  = true;
                    //echo $userId;

            }
        }
        $auth = $_SESSION['auth'] ?? null;
        if (!$auth) {
            header("Location: ./index.php");
            exit();
        }

        $this->view->generate('auth_view.php', 'template_view.php');
    }
}