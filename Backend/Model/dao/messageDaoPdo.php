<?php
// 此Dao用於管理訊息之新增、刪除、修改以及查詢的資料庫連線 

require_once '/htdocs/Backend/Model/bean/message.php';

class messageDaoPdo
{
    //===========================================================================
    //新增訊息 區域 start
    public function addMessage($message)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "INSERT INTO message (user_id, title , content , category_id) VALUES (:user_id, :title, :content, :category_id )";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $message->getUser_id(),
            'title' => $message->getTitle(),
            'content' => $message->getContent(),
            'category_id' => $message->getCategory_id()
        ]);
    }

    //新增訊息 區域 end
    //===========================================================================
    //刪除訊息 區域 start
    public function deleteMessageById($id)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "DELETE FROM message WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
    }

    //刪除訊息 區域 end
    //===========================================================================
    //修改訊息 區域 start
    public function updateMessage($message)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "UPDATE message SET title = :title, content = :content , category_id = :category_id  WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id' => $message->getId(),
            'title' => $message->getTitle(),
            'content' => $message->getContent(),
            'category_id' => $message->getCategory_id()
        ]);
    }

    //修改訊息 區域 end
    //===========================================================================
    //查詢訊息 區域 start
    // 1.查詢所有留言
    public function findMessages()
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "SELECT id, user_id, title, content, created_at, updated_at, category_id FROM message ORDER BY created_at DESC;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        // 將回傳之$stmt物件透過fetchAll()函數拆開
        $messageDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $messages = [];
        foreach ($messageDataArray as $messageData) {
            // 把拆開的陣列裝入message物件並回傳
            $message = new message();
            $message->setId($messageData['id']);
            $message->setUser_id($messageData['user_id']);
            $message->setTitle($messageData['title']);
            $message->setContent($messageData['content']);
            $message->setCategory_id($messageData['category_id']);
            $message->setDateCreatedAt($messageData['updated_at']);
            $message->setDateUpdateAt($messageData['created_at']);
            $message -> setUserIntoMessage();
            $message -> setCategoryIntoMessage();
            $messages[] = $message;
        }
        return $messages;
    }

    // 2.查詢所有留言(分頁)
    public function findMessagesByPage($startMessage, $messagesPerPage)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "SELECT id, user_id, title, content, created_at, updated_at, category_id FROM message ORDER BY created_at DESC LIMIT :startMessage, :messagesPerPage";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':startMessage', $startMessage, PDO::PARAM_INT);
        $stmt->bindParam(':messagesPerPage', $messagesPerPage, PDO::PARAM_INT);
        $stmt->execute();
        // 將回傳之$stmt物件透過fetchAll()函數拆開
        $messageDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $messages = [];
        foreach ($messageDataArray as $messageData) {
            // 把拆開的陣列裝入message物件並回傳
            $message = new message();
            $message->setId($messageData['id']);
            $message->setUser_id($messageData['user_id']);
            $message->setTitle($messageData['title']);
            $message->setContent($messageData['content']);
            $message->setCategory_id($messageData['category_id']);
            $message->setDateCreatedAt($messageData['updated_at']);
            $message->setDateUpdateAt($messageData['created_at']);
            $message -> setUserIntoMessage();
            $message -> setCategoryIntoMessage();
            $messages[] = $message;
        }
        return $messages;
    }

    // 3.查詢單筆留言
    public function findMessageById($id)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "SELECT id, user_id, title, content, created_at, updated_at, category_id FROM message WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
        // 將回傳之$stmt物件透過fetch()函數拆開
        $messageData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($messageData) {
            // 把拆開的陣列裝入message物件並回傳
            $message = new message();
            $message->setId($messageData['id']);
            $message->setUser_id($messageData['user_id']);
            $message->setTitle($messageData['title']);
            $message->setContent($messageData['content']);
            $message->setCategory_id($messageData['category_id']);
            $message->setDateCreatedAt($messageData['updated_at']);
            $message->setDateUpdateAt($messageData['created_at']);
            $message -> setUserIntoMessage();
            $message -> setCategoryIntoMessage();
            return $message;
        } else {
            return null;
        }
    }

    // 3.查詢歷史留言
    public function findHistoryMessages($user_id)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "SELECT id, user_id, title, content, created_at, updated_at, category_id FROM message WHERE user_id = :user_id ORDER BY created_at DESC;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $user_id
        ]);
        // 將回傳之$stmt物件透過fetchAll()函數拆開
        $messageDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $messages = [];
        foreach ($messageDataArray as $messageData) {
            // 把拆開的陣列裝入message物件並回傳
            $message = new message();
            $message->setId($messageData['id']);
            $message->setUser_id($messageData['user_id']);
            $message->setTitle($messageData['title']);
            $message->setContent($messageData['content']);
            $message->setCategory_id($messageData['category_id']);
            $message->setDateCreatedAt($messageData['updated_at']);
            $message->setDateUpdateAt($messageData['created_at']);
            $message -> setUserIntoMessage();
            $message -> setCategoryIntoMessage();
            $messages[] = $message;
        }
        return $messages;
    }

    // 4.查詢歷史留言(分頁)
    public function findHistoryMessagesByPage($user_id ,$startMessage ,$messagesPerPage)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "SELECT id, user_id, title, content, created_at, updated_at, category_id FROM message WHERE user_id = :user_id ORDER BY created_at DESC LIMIT :startMessage, :messagesPerPage;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':startMessage', $startMessage, PDO::PARAM_INT);
        $stmt->bindParam(':messagesPerPage', $messagesPerPage, PDO::PARAM_INT);
        $stmt->execute();
        // 將回傳之$stmt物件透過fetchAll()函數拆開
        $messageDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $messages = [];
        foreach ($messageDataArray as $messageData) {
            // 把拆開的陣列裝入message物件並回傳
            $message = new message();
            $message->setId($messageData['id']);
            $message->setUser_id($messageData['user_id']);
            $message->setTitle($messageData['title']);
            $message->setContent($messageData['content']);
            $message->setCategory_id($messageData['category_id']);
            $message->setDateCreatedAt($messageData['updated_at']);
            $message->setDateUpdateAt($messageData['created_at']);
            $message -> setUserIntoMessage();
            $message -> setCategoryIntoMessage();
            $messages[] = $message;
        }
        return $messages;
    }

    // 5.透過關鍵字查詢留言
    public function findMessagesByKeyWord($keyWord)
    {
        
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "SELECT id, user_id, title, content, created_at, updated_at, category_id FROM message WHERE title LIKE :keyWord ORDER BY created_at DESC;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':keyWord', '%' . $keyWord . '%', PDO::PARAM_STR);
        $stmt->execute();
        // 將回傳之$stmt物件透過fetchAll()函數拆開
        $messageDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $messages = [];
        foreach ($messageDataArray as $messageData) {
            // 把拆開的陣列裝入message物件並回傳
            $message = new message();
            $message->setId($messageData['id']);
            $message->setUser_id($messageData['user_id']);
            $message->setTitle($messageData['title']);
            $message->setContent($messageData['content']);
            $message->setCategory_id($messageData['category_id']);
            $message->setDateCreatedAt($messageData['updated_at']);
            $message->setDateUpdateAt($messageData['created_at']);
            $message -> setUserIntoMessage();
            $message -> setCategoryIntoMessage();
            $messages[] = $message;
        }
        return $messages;
    }

    // 6.透過關鍵字查詢留言(分頁)
    public function findMessagesByKeyWordAndPage($keyWord ,$startMessage ,$messagesPerPage)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "SELECT id, user_id, title, content, created_at, updated_at, category_id FROM message WHERE title LIKE :keyWord ORDER BY created_at DESC LIMIT :startMessage, :messagesPerPage;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':startMessage', $startMessage, PDO::PARAM_INT);
        $stmt->bindParam(':messagesPerPage', $messagesPerPage, PDO::PARAM_INT);
        // bindValue()是因為要綁定的值是%keyword%而不是單純一個變數；keyword是個字串，所以用PARAM_STR；%符號不能直接放在sql查詢語句裡面，所以在這邊綁入
        $stmt->bindValue(':keyWord', '%' . $keyWord . '%', PDO::PARAM_STR);
        $stmt->execute();
        // 將回傳之$stmt物件透過fetchAll()函數拆開
        $messageDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $messages = [];
        foreach ($messageDataArray as $messageData) {
            // 把拆開的陣列裝入message物件並回傳
            $message = new message();
            $message->setId($messageData['id']);
            $message->setUser_id($messageData['user_id']);
            $message->setTitle($messageData['title']);
            $message->setContent($messageData['content']);
            $message->setCategory_id($messageData['category_id']);
            $message->setDateCreatedAt($messageData['updated_at']);
            $message->setDateUpdateAt($messageData['created_at']);
            $message -> setUserIntoMessage();
            $message -> setCategoryIntoMessage();
            $messages[] = $message;
        }
        return $messages;
    }

    //查詢訊息 區域 end
    //===========================================================================
    //討論區分類 區域 start
    // 1.透過分類查找留言
    public function findMessagesByCategoryId($category_id)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "SELECT id, user_id, title, content, created_at, updated_at, category_id FROM message WHERE category_id = :category_id ORDER BY created_at DESC;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'category_id' => $category_id
        ]);
        // 將回傳之$stmt物件透過fetchAll()函數拆開
        $messageDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $messages = [];
        foreach ($messageDataArray as $messageData) {
            // 把拆開的陣列裝入message物件並回傳
            $message = new message();
            $message->setId($messageData['id']);
            $message->setUser_id($messageData['user_id']);
            $message->setTitle($messageData['title']);
            $message->setContent($messageData['content']);
            $message->setCategory_id($messageData['category_id']);
            $message->setDateCreatedAt($messageData['updated_at']);
            $message->setDateUpdateAt($messageData['created_at']);
            $message -> setUserIntoMessage();
            $message -> setCategoryIntoMessage();
            $messages[] = $message;
        }
        return $messages;
    }

    // 2.透過分類查找留言(分頁)
    public function findMessagesByCategoryIdAndPage($category_id ,$startMessage ,$messagesPerPage)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "SELECT id, user_id, title, content, created_at, updated_at, category_id FROM message WHERE category_id = :category_id ORDER BY created_at DESC LIMIT :startMessage, :messagesPerPage;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':startMessage', $startMessage, PDO::PARAM_INT);
        $stmt->bindParam(':messagesPerPage', $messagesPerPage, PDO::PARAM_INT);
        $stmt->execute();
        // 將回傳之$stmt物件透過fetchAll()函數拆開
        $messageDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $messages = [];
        foreach ($messageDataArray as $messageData) {
            // 把拆開的陣列裝入message物件並回傳
            $message = new message();
            $message->setId($messageData['id']);
            $message->setUser_id($messageData['user_id']);
            $message->setTitle($messageData['title']);
            $message->setContent($messageData['content']);
            $message->setCategory_id($messageData['category_id']);
            $message->setDateCreatedAt($messageData['updated_at']);
            $message->setDateUpdateAt($messageData['created_at']);
            $message -> setUserIntoMessage();
            $message -> setCategoryIntoMessage();
            $messages[] = $message;
        }
        return $messages;
    }

    //討論區分類 區域 end
    //===========================================================================
}
