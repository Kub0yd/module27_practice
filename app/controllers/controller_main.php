<?php
require_once 'app/heandlers/functions.php';
class Controller_Main extends Controller{
    
    
    function action_index(){

        //подключаем БД и обработчики
        $db = DbConn::connect();
        $heandler = new Functions($db);
        //обработка кнопки "ВЫЙТИ"
        if(isset($_POST['sign_out'])) {
            //стираем все куки и сессии
            $heandler->unsetAll();

        }
        //переадресация, если пользователь уже авторизован
        if ($_SESSION['auth']){
            header("Location: ./index.php?url=auth");
            exit();
        }
        $this->view->generate('main_view.php', 'template_view.php');
    }
    
}
?>