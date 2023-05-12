<?php
//генерация случйного кода
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
} 
//получаем все записи пользователя по логину
function getUserByLogin($login){
    include "db_conf.php";

    $login = $db->quote($login);
    $sql = "SELECT id, password, user_hash FROM users WHERE login = $login";
    $result = $db->query($sql)->FETCH(PDO::FETCH_ASSOC);

    return $result;
}
//получаем все записи пользователя по хэшу
function getUserByHash($hash){
    include "db_conf.php";
    if ($hash){
       $sql = "SELECT id, password, login FROM users WHERE user_hash = '$hash'";
        $result = $db->query($sql)->FETCH(PDO::FETCH_ASSOC); 
    }else {
        exit();
    }
    return $result;
}
//получаем все записи пользователя по id
function getUserById($id){
    include "db_conf.php";

    $id = $db->quote($id);
    $sql = "SELECT id, login, password, user_hash FROM users WHERE id = $id";
    $result = $db->query($sql)->FETCH(PDO::FETCH_ASSOC);

    return $result;
}
//получаем пароль пользователя по логину
function getUserPassword($login){

    $result = getUserByLogin($login);
    return $result['password'];
}
//получаем id пользователя по логину
function getUserId($login){

    $result = getUserByLogin($login);

    return $result['id'];
}
//получаем хэш пользователя по логину
function getUserHash($login){

    $result = getUserByLogin($login);

    return $result['user_hash'];
}
//получаем все записи по файлу по его наименованию
function getFileDataByName($filename){
    include "db_conf.php";

    $sql = "SELECT id, user_id, filename, upload_date FROM files WHERE filename = '$filename'";
    $result = $db->query($sql)->FETCH(PDO::FETCH_ASSOC);

    return $result;
}
//стирает все куки и сессии
function unsetAll(){
    foreach($_COOKIE as $key => $value) setcookie($key, '', time() - 3600*24*30*12, '/');
    //setcookie("id", "", time() - 3600*24*30*12, "/");
    //setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true); // httponly !!!
    session_unset();

}
//получаем все комментарии к изображению по id файла
function getCommentsByFile($id){
    include "db_conf.php";

    $sql = "SELECT id, user_id, comment, create_date FROM comments WHERE file_id = '$id'";
    $result = $db->query($sql)->FETCHALL(PDO::FETCH_ASSOC);

    return $result;
}
//get all users (id, login)
function getAllUsers(){
    include "db_conf.php";

    $sql = "SELECT id, login FROM users";
    $result = $db->query($sql)->FETCHALL(PDO::FETCH_ASSOC);

    return $result;
}
function isAdmin($usernameRoles){
    if (in_array("Administrator", $usernameRoles)){
        $isAdmin = 'checked';
    } else {
        $isAdmin = "";
    }
    return $isAdmin;
}
function isUser($usernameRoles){
    if (in_array("moderator", $usernameRoles)){
        $isUser = 'checked';
    } else {
        $isUser = "";
    }
    return $isUser;
}    
function isModerator($usernameRoles){
    if (in_array("user", $usernameRoles)){
        $isModerator = 'checked';
    } else {
        $isModerator = "";
    }
    return $isModerator;
}   
?>
