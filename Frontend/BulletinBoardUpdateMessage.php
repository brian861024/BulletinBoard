<?php require '/htdocs/Backend/Controller/messageController.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/img/icon/favicon.ico" type="" />
  <title>留言板 - 更新留言</title>

  <?php include 'C:\htdocs\Frontend\fragments\BulletinBoardFrame.php'; ?>

  <!-- CSS -->
  <link rel="stylesheet" href="../CSS/BulletinBoardUpdateMessage.css" />

</head>

<body>
  <!--===========================================================================-->
  <!--Header 區域 start-->
  <header>

    <?php include 'C:\htdocs\Frontend\fragments\BulletinBoardNavbar.php'; ?>

  </header>
  <!--Header 區域 end-->
  <!--===========================================================================-->
  <!--Container 區域 start-->
  <container>

    <!-- 左側導覽列 -->

    <?php include 'C:\htdocs\Frontend\fragments\BulletinBoardLeftNavbar.php'; ?>

    <!-- 右側內容區域 -->
    <div class="rightSectionArea">

      <div class="updateMassageTitle mb-2">
        <div class="updateMassageTitleColorBar"></div>
        <h2> 修改留言 </h2>
      </div>

      <div class="updateMassageFormArea">

        <?php
        $messageDaoPdo = new messageDaoPdo;
        session_start();
        // 先檢查導覽列有沒有messageid，沒有就給一個null，以免dao報錯
        $messageId = $_GET["messageId"] ?? null;
        if (!isset($messageId)) {
          echo '錯誤：無修改之文章<br>';
          echo '<a href="..\..\Frontend\BulletinBoardIndex.php">點擊此處去首頁。</a>';
          exit;
        }
        //先把這則message透過id取出來
        $message = $messageDaoPdo->findMessageById($messageId);
        // 檢查message存不存在
        if (!isset($message)) {
          echo '錯誤：無修改之文章<br>';
          echo '<a href="..\..\Frontend\BulletinBoardIndex.php">點擊此處去首頁。</a>';
          exit;
        }
        $user = $message->getUser();
        $messageUserId = $user->getId();
        $currentUserId = $_SESSION['userId'];
        // 檢查文章的user跟登入中的user是否一致
        if ($messageUserId !== $currentUserId ) {
          echo '錯誤：此非您發表之留言<br>';
          echo '<a href="..\..\Frontend\BulletinBoardIndex.php">點擊此處去首頁。</a>';
          exit;
        }

        $categoryId = $message->getCategory_id();
        ?>

        <!----------------更新留言 form ---------------->
        <form class="pure-form" action="../Backend/Service/messageService.php" method="post" name="updateMassageForm" id="updateMassageForm">
          <fieldset class="pure-group">
            <!-- 用來分辨要使用哪一個controller方法 -->
            <input type="hidden" name="functionName" value="updateMessage">
            <!-- 用來確認當前登入者和修改者為同一個人 -->
            <!-- 在載入頁面的時候就已經把MessageId放進去隱藏欄位了，所以就算更改URL，那也不會修改到其他id的留言 -->
            <input type="hidden" name="messageId" value="<?php echo $message->getId(); ?>">
            <input type="hidden" name="currentUserId" value="<?php echo $currentUserId ?>">
            <input type="hidden" name="messageUserId" value="<?php echo $messageUserId ?>">

            <input type="text" class="pure-input-1 mt-2" name="messageTitle" id="messageTitle" placeholder="修改後的標題" value="<?php
                                                                                                                            if (isset($message)) {
                                                                                                                              echo $message->getTitle();
                                                                                                                            } ?>" />
            <br>
            <select class="mb-4" name="categoryId" id="categoryId">
              <option value="1" <?php if ($categoryId == 1) echo 'selected'; ?>>心情</option>
              <option value="2" <?php if ($categoryId == 2) echo 'selected'; ?>>工作</option>
              <option value="3" <?php if ($categoryId == 3) echo 'selected'; ?>>感情</option>
              <option value="4" <?php if ($categoryId == 4) echo 'selected'; ?>>運動</option>
              <option value="5" <?php if ($categoryId == 5) echo 'selected'; ?>>星座</option>
              <option value="6" <?php if ($categoryId == 6) echo 'selected'; ?>>遊戲</option>
              <option value="7" <?php if ($categoryId == 7) echo 'selected'; ?>>閒聊</option>
            </select>
            <fieldset class="pure-group">
              <textarea class="pure-input-1" name="messageContent" id="messageContent" placeholder="修改後的留言" style="height: 400px ;min-height: 100px;max-height: 400px"><?php
                                                                                                                                                                        if (isset($message)) {
                                                                                                                                                                          echo $message->getContent();
                                                                                                                                                                        }
                                                                                                                                                                        ?></textarea>
            </fieldset>
        </form>
        <!----------------更新留言 form ---------------->

        <!----------------刪除留言 form (隱藏)---------------->
        <form action="../Backend/Service/messageService.php" method="post" name="deleteMessageForm" id="deleteMessageForm" style="display: none;">
          <!-- 用來分辨要使用哪一個controller方法 -->
          <input type="hidden" name="functionName" value="deleteMessage">
          <!-- 用來確認當前登入者和刪除者為同一個人 -->
          <input type="hidden" name="messageId" value="<?php echo $messageId ?>">
          <input type="hidden" name="currentUserId" value="<?php echo $currentUserId ?>">
          <input type="hidden" name="messageUserId" value="<?php echo $messageUserId ?>">
        </form>
        <!----------------刪除留言 form (隱藏)---------------->

        <div class="buttonArea">
          <button type="button" class="btn btn-primary pure-input-1-2" onclick="submitUpdateMassageForm()">確認修改</button>
          <button type="button" class="btn btn-danger pure-input-1-5" onclick="submitDeleteMessageForm()">刪除留言</button>
          <button type="button" class="btn btn-secondary pure-input-1-5" onclick="goBack()">取消修改</button>
        </div>

      </div>

    </div>

  </container>
  <!--Container 區域 end-->
  <!--===========================================================================-->
  <!--Footer 區域 start-->
  <footer>
    <div class="footerSectionArea">

    </div>
    <div class="subfooter">
      <a>Copyright &copy; 2024 國立中央大學 版權所有 All rights reserved.</a>
    </div>
  </footer>
  <!--Footer 區域 end-->
  <!--===========================================================================-->

  <script>
    function submitDeleteMessageForm() {
      if (confirm("確認刪除嗎？此操作不可復原")) {
        document.getElementById("deleteMessageForm").submit();
      } else {
        return false;
      }
    }

    function submitUpdateMassageForm() {
      if (confirm("確認修改嗎？")) {
        document.getElementById("updateMassageForm").submit();
      } else {
        return false;
      }
    }

    function goBack() {
      window.history.back();
    }
  </script>

</body>

</html>