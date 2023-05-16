<?php
require_once 'app/heandlers/functions.php';
require_once 'app/heandlers/rolemanager.php';
// require_once 'app/models/db_conf.php';
// include './app/models/db_conf.php';
class Controller_Registration extends Controller {

    function action_index(){

         //подгружаем данные из модели
        $this->model = new Model_Registration();  
        $data = $this->model->get_data();

        $this->view->generate('registration_view.php', 'template_view.php', $data);

        //подключаем БД и обработчики
        $db = DbConn::connect();
        $heandler = new Functions($db);

        //переадресация, если пользователь уже авторизован
        $auth = $_SESSION['auth'] ?? null;
        if ($auth) {
            header("Location: ./index.php?url=auth");
        }
        //обработка регистрации
        if(isset($_POST['registration'])){   
            $err = [];
            // проверяем логин
            if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['username']))
            {
                $err[] = "Логин может состоять только из букв английского алфавита и цифр";
            } 
            if(strlen($_POST['username']) < 3 or strlen($_POST['username']) > 30)
            {
                $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
            } 
            // проверяем, не существует ли пользователя с таким именем
            $username = $db->quote($_POST['username']);
            $query = $db->query("SELECT id FROM users WHERE login=$username");
            if($query->rowCount() > 0)
            {
                $err[] = "Пользователь с таким логином уже существует в базе данных";
            } 
            // Если нет ошибок, то добавляем в БД нового пользователя
            if(count($err) == 0)
            {
            //создаем обрабочтик ролей
            $roleManager = new UserRoleManager($db);
            $username = $db->quote($_POST['username']);
            // Убираем лишние пробелы и делаем хэширование
            $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (login, password) VALUES ($username, '$password' )";
            $db->query($sql);
            //после добавления пользователя в бд назначеем ему роль
            $roleManager->assignRole($heandler->getUserId($_POST['username'], $db), $roleManager->getRoleId("user"), null);
            echo "<script>alert(\"Вы успешно зарегистрировались!\");</script>";
            header("Location: ./index.php?url=login");
            }
            else
            {
                print "<b>При регистрации произошли следующие ошибки:</b><br>";
                foreach($err AS $error)
                {
                    print $error."<br>";

                }
            }
        }
    }
}