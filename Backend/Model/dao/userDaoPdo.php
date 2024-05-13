<?php
// 此Dao用於管理用戶之註冊、登入以及修改資料的資料庫連線 

require_once '/htdocs/Backend/Model/bean/user.php';

class userDaoPdo
{
    // ===========================================================================
    // 查詢 區域 start
    // 1.登入
    // 透過username尋找用戶(登入用)
    public function findUserByUsername_ReturnUserObject($userName)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "SELECT id, userName, password, email, updated_at, created_at FROM users WHERE userName = :userName";
        // executeQuery()自定義函數 回傳一個 物件 至 自定義變數$stmt
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'userName' => $userName
        ]);
        // 將回傳之$stmt物件透過fetch()函數拆開
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($userData) {
            // 把拆開的陣列裝入user物件並回傳
            $user = new user();
            $user->setId($userData['id']);
            $user->setUsername($userData['userName']);
            $user->setPassword($userData['password']);
            $user->setEmail($userData['email']);
            $user->setDateCreatedAt($userData['updated_at']);
            $user->setDateUpdateAt($userData['created_at']);
            return $user;
        } else {
            return null;
        }
    }

    // 2.透過userId查user物件
    public function findUserByUserId($id){
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "SELECT id, userName, password, email, updated_at, created_at FROM users WHERE id = :id";
        // executeQuery()自定義函數 回傳一個 物件 至 自定義變數$stmt
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
        // 將回傳之$stmt物件透過fetch()函數拆開
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($userData) {
            // 把拆開的陣列裝入user物件並回傳
            $user = new user();
            $user->setId($userData['id']);
            $user->setUsername($userData['userName']);
            $user->setPassword($userData['password']);
            $user->setEmail($userData['email']);
            $user->setDateCreatedAt($userData['updated_at']);
            $user->setDateUpdateAt($userData['created_at']);
            return $user;
        } else {
            return null;
        }
    }

    // 查詢 區域 end
    // ===========================================================================
    // 註冊 區域 start
    // 1.新增使用者
    public function addUser($user)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "INSERT INTO users (userName, password , email) VALUES (:userName, :password, :email )";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'userName' => $user->getUserName(),
            'password' => $user->getPassword(),
            'email' => $user->getEmail()
        ]);
    }

    // 2.查詢資料庫有沒有前端傳入的userName的user
    public function findUserByUserName($userName)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "SELECT id, userName, password, email, updated_at, created_at FROM users WHERE userName = :userName";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['userName' => $userName]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userData;
    }

    // 3.查詢資料庫有沒有前端傳入的email的user
    public function findUserByEmail($email)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "SELECT id, userName, password, email, updated_at, created_at FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userData;
    }

    // 註冊 區域 end
    // ===========================================================================
    // 修改用戶名稱 區域 start
    public function updateUserNameById($userId, $newUsername)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "UPDATE users , updated_at = NOW() SET username = :username WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $newUsername,
            'id' => $userId
        ]);
    }

    // 修改用戶名稱 區域 end
    // ===========================================================================
    // 修改密碼 區域 start
    public function updatePasswordById($userId, $newPassword)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "UPDATE users , updated_at = NOW() SET password = :password WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'password' => $newPassword,
            'id' => $userId
        ]);
    }

    // 修改密碼 區域 end
    // ===========================================================================
    // 修改Email 區域 start
    public function updateEmailById($userId, $newEmail)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "UPDATE users , updated_at = NOW() SET email = :email WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'email' => $newEmail,
            'id' => $userId
        ]);
    }

    // 修改Email 區域 end
    // ===========================================================================

}
