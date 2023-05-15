<?php
// header("Location: ./index.php");


class UserRoleManager {
    private $db;
      
    public function __construct($db) {
      $this->db = $db;
    }
    //Добавление роли
    public function addRole($roleName) {
        $stmt = $this->db->prepare("INSERT INTO roles (role_name) VALUES (?)");
        $stmt->bindParam(1, $roleName);
        $stmt->execute();
    }
    //получаем список всех ролей
    public function getRoles() {
        $roles = array();
        $stmt = $this->db->query("SELECT * FROM roles");
        $result = $stmt->FetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row){
        $roles[] = $row["role_name"];
        }
        return $roles;
        
    }
    //назначение роли пользователю
    public function assignRole($userId, $roleId, $vkUserId) {
        //используем bindValue, потому что можем записывать NULL в таблицу
        $stmt = $this->db->prepare("INSERT INTO user_roles (user_id, role_id, vk_user_id) VALUES (:userId, :roleId, :vkUserId)"); 
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT); 
        $stmt->bindValue(':roleId', $roleId, PDO::PARAM_INT); 
        $stmt->bindValue(':vkUserId', $vkUserId, PDO::PARAM_INT); 
        $stmt->execute(); 
    }
    //получаем все роли пользователя
    public function getUserRoles($userId) {
        $userRoles = array();
        $stmt = $this->db->query("SELECT roles.role_name FROM roles INNER JOIN user_roles ON roles.id = user_roles.role_id WHERE user_roles.user_id = $userId");
        $result = $stmt->FetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
        //echo var_dump($row);
        $userRoles[] = $row['role_name'];
        }
        return $userRoles;
    }
    //получаем все роли пользователя ВК
    public function getVkUserRoles($vkUsersId) {
        $userRoles = array();
        $stmt = $this->db->query("SELECT roles.role_name FROM roles INNER JOIN user_roles ON roles.id = user_roles.role_id WHERE user_roles.vk_user_id = $vkUsersId");
        $result = $stmt->FetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
        //echo var_dump($row);
        $userRoles[] = $row['role_name'];
        }
        return $userRoles;
    }
    //получаем id роли по названию
    public function getRoleId($roleName){
        $stmt = $this->db->query("SELECT id FROM roles WHERE role_name = '$roleName'");
        $result = $stmt->FETCH(PDO::FETCH_ASSOC);
        return $result["id"];
    }

}      


?>