<?php
class Controller_Main extends Controller{
    
    
    function action_index(){
        
        // session_start();
        $superUser = false;
        
        // $userDataByHash = getUserByHash($_SESSION['hash']);
        // echo "<script>alert(\"class\");</script>";
        //проверяем пришедшие со страницы аутентификации куки
        if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
            //получаем информацию о юзере через id
            $userId = $_COOKIE['id'];
            $userData = getUserById($userId);
            echo "куки";
            //если хэш или id не совпадают, стираем все куки и сессии
            if (($userData['user_hash'] !== $_COOKIE['hash']) or ($userData['id'] !== $_COOKIE['id'])) {

                
                echo "<script>alert(\"Что-то пошло не так с авторизацией.. Попробуйте повторить вход\");</script>";
                // header('Location: ?=login');          
            }else{
                // echo "<script>alert(\"cookie\");</script>";
                //ставим отметку авторизованного пользователя
                // $_SESSION['auth']  = 1;
                $_SESSION['auth']  = true;
                //echo $userId;
            }
        }else if (isset($_SESSION['hash'])) {
            $userDataByHash = getUserByHash($_SESSION['hash']);
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
        if(isset($_POST['sign_out'])) {
            // echo "<script>alert(\"fsfsfsf\");</script>";
            unsetAll();
            // header("Location: ./"); 
        }
        
        $this->view->generate('main_view.php', 'template_view.php');
    }
    
}
?>