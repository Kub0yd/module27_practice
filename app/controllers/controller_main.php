<?php
require_once 'app/heandlers/functions.php';
class Controller_Main extends Controller{
    
    
    function action_index(){

        
        // $superUser = false;
        $db = DbConn::connect();
        $heandler = new Functions($db);
 
        if(isset($_POST['sign_out'])) {
            // echo "<script>alert(\"fsfsfsf\");</script>";
            $heandler->unsetAll();
            // header("Location: ./"); 
        }
      
        if ($_SESSION['auth']){
            header("Location: ./index.php?url=auth");
            exit();
        }
        $this->view->generate('main_view.php', 'template_view.php');
    }
    
}
?>