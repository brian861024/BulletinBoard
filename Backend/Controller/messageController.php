<?php
// 此控制器用於管理訊息之新增、刪除、修改以及查詢的邏輯

require_once '/htdocs/Backend/Model/dao/messageDaoPdo.php';
require_once '/htdocs/Backend/Model/bean/message.php';

class messageController
{
    //===========================================================================
    //新增訊息 區域 start
    // 1.一般新增
    //邏輯：
    //。比對標題是否多於30字
    //。比對內容是否多於300字
    //。創立一個Message物件寫入資料後丟到Dao寫入資料庫
    function newMessage()
    {
        $messageContent = htmlspecialchars($_POST['messageContent'], ENT_QUOTES, 'UTF-8');
        $messageTitle = htmlspecialchars($_POST['messageTitle'], ENT_QUOTES, 'UTF-8');
        $categoryId = $_POST['categoryId'];
        session_start();
        $messageDaoPdo = new messageDaoPdo;

        //。比對標題是否多於30字，utf-8編碼中中文字數大部分是三個字符
        if (strlen($messageTitle) < 90) {
            //。比對內容是否多於300字
            if (strlen($messageContent) < 900) {
                //。創立一個Message物件寫入資料後丟到Dao寫入資料庫
                $message = new message;
                $message->setUser_id($_SESSION['userId']);
                $message->setTitle($messageTitle);
                $message->setCategory_id($categoryId);
                $message->setContent($messageContent);
                $messageDaoPdo->addMessage($message);
                unset($_SESSION['messageTitle']);
                unset($_SESSION['categoryId']);
                unset($_SESSION['messageContent']);
                echo "<script type='text/javascript'>
                alert('留言新增成功！將導至主頁');
                </script>";
                // 用Location不會顯示彈窗
                header("refresh:0;url=../../Frontend/BulletinBoardIndex.php");
                exit;
            } else {
                $_SESSION['messageTitle'] = $messageTitle;
                $_SESSION['categoryId'] = $categoryId;
                $_SESSION['messageContent'] = $messageContent;
                echo "<script type='text/javascript'>
                alert('內容字數不得大於300字');
                </script>";
                header("refresh:0;url=..\..\Frontend\BulletinBoardNewMessage.php");
                exit;
            }
        } else {
            $_SESSION['messageTitle'] = $messageTitle;
            $_SESSION['categoryId'] = $categoryId;
            $_SESSION['messageContent'] = $messageContent;
            echo "<script type='text/javascript'>
            alert('標題字數不得大於30字');
            </script>";
            header("refresh:0;url=..\..\Frontend\BulletinBoardNewMessage.php");
            exit;
        }
    }
    //新增訊息 區域 end
    //===========================================================================
    //刪除訊息 區域 start
    // 1.一般刪除
    function deleteMessage()
    {
        $messageId = $_POST['messageId'];
        $currentUserId = $_POST['currentUserId'];
        $messageUserId = $_POST['messageUserId'];
        $messageDaoPdo = new messageDaoPdo;
        session_start();
        if($currentUserId == $_SESSION['userId']){
            if($currentUserId == $messageUserId){
                echo "<script type='text/javascript'>
                alert('刪除成功，將導至首頁');
                </script>";
                $messageDaoPdo -> deleteMessageById($messageId);
                header("refresh:0;url=..\..\Frontend\BulletinBoardIndex.php");
                exit;
            } else {
                echo "<script type='text/javascript'>
                alert('非發文者，無法刪除！');
                </script>";
                header("refresh:0;url=..\..\Frontend\BulletinBoardIndex.php");
                exit;
            }
        } else {
            echo "<script type='text/javascript'>
            alert('登入逾期，請重新登入');
            </script>";
            header("refresh:0;url=..\..\Frontend\BulletinBoardLogin.php");
            exit;
        }
    }

    //刪除訊息 區域 end
    //===========================================================================
    //修改訊息 區域 start
    // 1.一般修改
    function updateMessage()
    {
        $messageId = $_POST['messageId'];
        $currentUserId = $_POST['currentUserId'];
        $messageUserId = $_POST['messageUserId'];
        $messageContent = htmlspecialchars($_POST['messageContent'], ENT_QUOTES, 'UTF-8');
        $messageTitle = htmlspecialchars($_POST['messageTitle'], ENT_QUOTES, 'UTF-8');
        $categoryId = $_POST['categoryId'];
        session_start();
        $messageDaoPdo = new messageDaoPdo;
        if($currentUserId == $_SESSION['userId']){
            if($currentUserId == $messageUserId){
                //。比對標題是否多於30字，utf-8編碼中中文字數大部分是三個字符
                if (strlen($messageTitle) < 90) {
                    //。比對內容是否多於300字
                    if (strlen($messageContent) < 900) {
                        //。創立一個Message物件寫入資料後丟到Dao寫入資料庫
                        $message = new message;
                        $message->setId($messageId);
                        $message->setUser_id($messageUserId);
                        $message->setTitle($messageTitle);
                        $message->setCategory_id($categoryId);
                        $message->setContent($messageContent);
                        $messageDaoPdo->updateMessage($message);
                        unset($_SESSION['messageTitle']);
                        unset($_SESSION['categoryId']);
                        unset($_SESSION['messageContent']);
                        echo "<script type='text/javascript'>
                        alert('留言修改成功！將導至主頁');
                        </script>";
                        header("refresh:0;url=..\..\Frontend\BulletinBoardIndex.php");
                        exit;
                    } else {
                        $_SESSION['messageTitle'] = $messageTitle;
                        $_SESSION['categoryId'] = $categoryId;
                        $_SESSION['messageContent'] = $messageContent;
                        echo "<script type='text/javascript'>
                        alert('內容字數不得大於300字');
                        </script>";
                        header("refresh:0;url=..\..\Frontend\BulletinBoardUpdateMessage.php");
                        exit;
                    }
                } else {
                    $_SESSION['messageTitle'] = $messageTitle;
                    $_SESSION['categoryId'] = $categoryId;
                    $_SESSION['messageContent'] = $messageContent;
                    echo "<script type='text/javascript'>
                    alert('標題字數不得大於30字');
                    </script>";
                    header("refresh:0;url=..\..\Frontend\BulletinBoardUpdateMessage.php");
                    exit;
                }
            } else {
                echo "<script type='text/javascript'>
                alert('非發文者，無法刪除！');
                </script>";
                header("refresh:0;url=..\..\Frontend\BulletinBoardIndex.php");
                exit;
            }
        } else {
            echo "<script type='text/javascript'>
            alert('登入逾期，請重新登入');
            </script>";
            header("refresh:0;url=..\..\Frontend\BulletinBoardLogin.php");
            exit;
        }
    }
    //修改訊息 區域 end
    //===========================================================================
    //查詢訊息 區域 start
    // 1.關鍵字查詢
    function findMessageByKeyword()
    {
    }

    // 2.歷史留言
    function findMessageByUserId()
    {
    }

    //查詢訊息 區域 end
    //===========================================================================
    //討論區分類 區域 start
    // 1.透過分類查找留言
    function findMessageByCategory()
    {
        $categoryId = $_POST['categoryId'];
        $messageDaoPdo = new messageDaoPdo;
        $messageDaoPdo->findMessagesByCategoryId($categoryId);
    }

    //討論區分類 區域 end
    //===========================================================================
    //分頁功能 區域 start
    // 1.獲得總頁數、起始頁數跟當前頁面起始留言
    function getPages($messageNums, $messagesPerPage)
    {
        // 計算總共幾頁
        $pages = ceil($messageNums / $messagesPerPage);
        
        if (!isset($_GET["page"])) {
            // 如果未設置 $_GET["page"]，則預設為第一頁
            $page = 1;
        } else {
            // 確認頁數只能夠是數值資料
            $page = intval($_GET["page"]);
        }
        // 當前頁面該從哪一個留言開始
        $startMessage = ($page - 1) * $messagesPerPage;
    
        // 回傳包含總頁數、起始頁數跟當前頁面起始留言的陣列
        return array(
            "totalPages" => $pages,
            "currentPage" => $page,
            "startMessage" => $startMessage
        );
    }

    //分頁功能 區域 end
    //===========================================================================
}
