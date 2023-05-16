<?php

class DbConn {

    
    public static function connect()
    {
        $host = 'localhost';
        $db = 'auth';
        $user = "root";
        $password = "";
        $db = new PDO("mysql:host=$host;dbname=$db", $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return $db;
    }
   
}
class Functions {
    private $db;
      
    public function __construct($db) {
      $this->db = $db;
    }
    //генерация случйного кода
    public function generateCode($length=6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
                $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    } 
    //получаем все записи пользователя по логину
    public function getUserByLogin($login){
        // include "db_conf.php";
        
        $login = $this->db->quote($login);
        $sql = "SELECT id, password, user_hash FROM users WHERE login = $login";
        $result = $this->db->query($sql)->FETCH(PDO::FETCH_ASSOC);

        return $result;
    }
    //получаем все записи пользователя по хэшу
    public function getUserByHash($hash){
        // include "db_conf.php";
        if ($hash){
        $sql = "SELECT id, password, login FROM users WHERE user_hash = '$hash'";
            $result = $this->db->query($sql)->FETCH(PDO::FETCH_ASSOC); 
        }else {
            exit();
        }
        return $result;
    }
    //получаем все записи пользователя по id
    public function getUserById($id){
        // include "db_conf.php";

        $id = $this->db->quote($id);
        $sql = "SELECT id, login, password, user_hash FROM users WHERE id = $id";
        $result = $this->db->query($sql)->FETCH(PDO::FETCH_ASSOC);

        return $result;
    }
    //получаем пароль пользователя по логину
    public function getUserPassword($login){

        $result = self::getUserByLogin($login);
        return $result['password'];
    }
    //получаем id пользователя по логину
    public function getUserId($login){

        $result = self::getUserByLogin($login);

        return $result['id'];
    }
    //получаем хэш пользователя по логину
    public function getUserHash($login){

        $result =self::getUserByLogin($login);

        return $result['user_hash'];
    }
    //получаем все записи по файлу по его наименованию
    public function getFileDataByName($filename){
        // include "db_conf.php";

        $sql = "SELECT id, user_id, filename, upload_date FROM files WHERE filename = '$filename'";
        $result = $this->db->query($sql)->FETCH(PDO::FETCH_ASSOC);

        return $result;
    }
    //стирает все куки и сессии
    public function unsetAll(){
        foreach($_COOKIE as $key => $value) setcookie($key, '', time() - 3600*24*30*12, '/');
        //setcookie("id", "", time() - 3600*24*30*12, "/");
        //setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true); // httponly !!!
        // $_POST = [];
        session_unset();

    }
    //получаем все комментарии к изображению по id файла
    public function getCommentsByFile($id){
        // include "db_conf.php";

        $sql = "SELECT id, user_id, comment, create_date FROM comments WHERE file_id = '$id'";
        $result = $this->db->query($sql)->FETCHALL(PDO::FETCH_ASSOC);

        return $result;
    }
    //get all users (id, login)
    public function getAllUsers(){
        // include "db_conf.php";

        $sql = "SELECT id, login FROM users";
        $result = $this->db->query($sql)->FETCHALL(PDO::FETCH_ASSOC);

        return $result;
    }
    //получаем пользователя VK
    public function getVkUser($userid){
        $sql = "SELECT id, user_id, token FROM vk_users WHERE user_id = '$userid'";
        $result = $this->db->query($sql)->FETCH(PDO::FETCH_ASSOC);

        return $result;
    }
    // public function isAdmin($usernameRoles){
    //     if (in_array("Administrator", $usernameRoles)){
    //         $isAdmin = 'checked';
    //     } else {
    //         $isAdmin = "";
    //     }
    //     return $isAdmin;
    // }
    // public function isUser($usernameRoles){
    //     if (in_array("moderator", $usernameRoles)){
    //         $isUser = 'checked';
    //     } else {
    //         $isUser = "";
    //     }
    //     return $isUser;
    // }    
    // public function isModerator($usernameRoles){
    //     if (in_array("user", $usernameRoles)){
    //         $isModerator = 'checked';
    //     } else {
    //         $isModerator = "";
    //     }
    //     return $isModerator;
    // }   
}

?>
