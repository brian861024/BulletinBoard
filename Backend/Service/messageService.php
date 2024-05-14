<?php
// 此Service層級用於管理分配控制器任務，用以設定權限、可用服務等業務。

require '/htdocs/Backend/Controller/messageController.php';

// 前端回傳一個$_POST，$_POST裡面有一個functionName鍵，透過裡面的值來判斷要導到哪一個Service
if (isset($_POST['functionName'])) {
    //isset() 用於檢查變量是否已被設置並且不是null
    $functionName = $_POST['functionName'];
    switch ($functionName) {
        case 'newMessage':
            newMessage();
            break;
        case 'deleteMessage':
            deleteMessage();
            break;
        case 'updateMessage':
            updateMessage();
            break;
        case 'findMessageByKeyword':
            findMessageByKeyword();
            break;
        case 'findMessageByUserId':
            findMessageByUserId();
            break;
        case 'findMessageByCategory':
            findMessageByCategory();
            break;
        default:
            echo '未知的functionName';
            // 當 functionName 沒有被指定時，返回錯誤訊息
            break;
    }
}
//===========================================================================
//新增訊息 區域 start
function newMessage()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['messageTitle']) && !empty($_POST['categoryId']) && !empty($_POST['messageContent'])) {
        $messageController = new messageController;
        $messageController -> newMessage();
    } else {
        // 將POST表單中輸入的資料放入SESSION然後預設放入，如此使用者不必因為錯誤而重新輸入內容
        $_SESSION['messageTitle'] = $_POST['messageTitle'];
        $_SESSION['categoryId'] = $_POST['categoryId'];
        $_SESSION['messageTitle'] = $_POST['messageTitle'];
        echo "<script type='text/javascript'>
        alert('未使用POST方法傳送表單，或者表單欄位空缺');
        </script>";
        header("refresh:0;url=..\..\Frontend\BulletinBoardNewMessage.php");
    }
}
//新增訊息 區域 end
//===========================================================================
//刪除訊息 區域 start
// 1.一般會員刪除留言
function deleteMessage()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['messageId']) && !empty($_POST['currentUserId']) && !empty($_POST['messageUserId'])) {
        $messageController = new messageController;
        $messageController -> deleteMessage();
    } else {
        echo "<script type='text/javascript'>
        alert('未使用POST方法傳送表單，或者表單欄位空缺');
        </script>";
        header("refresh:0;url=..\..\Frontend\BulletinBoardNewMessage.php");
    }
}
//刪除訊息 區域 end
//===========================================================================
//修改訊息 區域 start
// 1.一般會員更新留言
function updateMessage()
{
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['messageId']) && !empty($_POST['currentUserId']) && !empty($_POST['messageUserId']) && !empty($_POST['messageTitle']) && !empty($_POST['categoryId']) && !empty($_POST['messageContent'])) {
        $messageController = new messageController;
        $messageController -> updateMessage();
    } else {
        // 將POST表單中輸入的資料放入SESSION然後預設放入，如此使用者不必因為錯誤而重新輸入內容
        $_SESSION['messageTitle'] = $_POST['messageTitle'];
        $_SESSION['categoryId'] = $_POST['categoryId'];
        $_SESSION['messageTitle'] = $_POST['messageTitle'];
        echo "<script type='text/javascript'>
        alert('未使用POST方法傳送表單，或者表單欄位空缺');
        </script>";
        header("refresh:0;url=..\..\Frontend\BulletinBoardNewMessage.php");
    }
}
//修改訊息 區域 end
//===========================================================================
//查詢訊息 區域 start
// 以下function因為不用透過請求來獲得後端資料，所以目前沒有使用到
// 1.透過關鍵字查詢訊息
function findMessageByKeyword()
{
}

// 2.透過使用者id查詢訊息
function findMessageByUserId()
{
}

// 3.
function findMessageByCategory()
{
}
//查詢訊息 區域 end
//===========================================================================
