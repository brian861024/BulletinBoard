<?php
// 此Service層級用於管理分配控制器任務，用以設定權限、可用服務等業務。

require '/htdocs/Backend/Controller/userController.php';

// 前端回傳一個$_POST，$_POST裡面有一個functionName鍵，透過裡面的值來判斷要使用哪一個方法
if (isset($_POST['functionName'])) {
    //isset() 用於檢查變量是否已被設置並且不是null
    $functionName = $_POST['functionName'];
    switch ($functionName) {
        case 'login':
            login();
            break;
        case 'logout':
            logout();
            break;
        case 'register':
            register();
            break;
        case 'updatePassword':
            updatePassword();
            break;
        case 'updateEmail':
            updateEmail();
            break;
        default:
            echo '未知的functionName';
            // 當 functionName 沒有被指定時，返回錯誤訊息
            break;
    }
}

//===========================================================================
//登入/登出 區域 start
// 1.登入
function login(){
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name']) && isset($_POST['password']) && isset($_POST['otp'])) {
    $userController = new userController;
    $userController -> login();
    } else {
        echo "<script type='text/javascript'>
        alert('未使用POST方法傳送表單，或者表單欄位空缺');
        </script>";
        header("refresh:0;url=..\..\Frontend\BulletinBoardLogin.php");
    }
}

// 2.登出 
function logout(){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userController = new userController;
        $userController -> logout();
    } else {
        echo "<script type='text/javascript'>
        alert('無登入中之使用者');
        </script>";
        header("refresh:0;url=..\..\Frontend\BulletinBoardLogin.php");
    }
}

//登入/登出 區域 end
//===========================================================================
//新增用戶 區域 start
// 1.註冊
function register(){
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['name']) && !empty($_POST['password1']) && !empty($_POST['password2']) && !empty($_POST['email'])) {
        $userController = new userController;
        $userController -> register();
    } else {
        echo "<script type='text/javascript'>
        alert('未使用POST方法傳送表單，或者表單欄位空缺');
        </script>";
        // echo '未使用POST方法傳送表單';
        header("refresh:0;url=..\..\Frontend\BulletinBoardRegister.php");
    }
}

//新增用戶 區域 end
//===========================================================================
//修改資訊 區域 start
// 1.修改密碼
function updatePassword(){
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['previousPassword']) && !empty($_POST['newPassword1']) && !empty($_POST['newPassword2'])) {
        $userController = new userController;
        $userController -> updatePassword();
    } else {
        echo "<script type='text/javascript'>
        alert('未使用POST方法傳送表單，或者表單欄位空缺');
        </script>";
        header("refresh:0;url=..\..\Frontend\BulletinBoardUpdatePassword.php");
    }
}

// 2.修改信箱
function updateEmail(){
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['previousEmail']) && !empty($_POST['newEmail'])) {
        $userController = new userController;
        $userController -> updateEmail();
    } else {
        echo "<script type='text/javascript'>
        alert('未使用POST方法傳送表單，或者表單欄位空缺');
        </script>";
        header("refresh:0;url=..\..\Frontend\BulletinBoardUpdateEmail.php");
    }
}
//修改資訊 區域 end
//===========================================================================

?>