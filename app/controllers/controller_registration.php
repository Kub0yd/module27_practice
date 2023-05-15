<?php
require_once 'app/heandlers/functions.php';
require_once 'app/heandlers/rolemanager.php';
// require_once 'app/models/db_conf.php';
// include './app/models/db_conf.php';
class Controller_Registration extends Controller {

    function action_index(){

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
        
        $this->view->generate('registration_view.php', 'template_view.php', $data);
        $db = DbConn::connect();
        $heandler = new Functions($db);
        $auth = $_SESSION['auth'] ?? null;
        if ($auth) {
            header("Location: ./index.php?url=auth");
        }
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
            $roleManager = new UserRoleManager($db);
            $username = $db->quote($_POST['username']);
            // Убираем лишние пробелы и делаем хэширование
            $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (login, password) VALUES ($username, '$password' )";
            $db->query($sql);
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