<?php require '/htdocs/Backend/Controller/messageController.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/img/icon/favicon.ico" type="" />
  <title>留言板 - 查看文章</title>

  <?php include 'C:\htdocs\Frontend\fragments\BulletinBoardFrame.php'; ?>

  <!-- CSS -->
  <link rel="stylesheet" href="../CSS/BulletinBoardViewMessage.css" />

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

      <?php
      $messageDaoPdo = new messageDaoPdo;
      // 先檢查messageId是否存在，不存在就給他null值，以免下方Dao搜尋報錯
      $messageId = $_GET["messageId"] ?? null;
      // 有messageId就繼續往下
      if ($messageId) {
        // Dao搜尋，尋找此id之留言
        $message = $messageDaoPdo->findMessageById($messageId);
        // 如果沒有就顯示無此文章
        if (!$message) {
          echo '<div class="viewMassageTitle mb-2">
                  <div class="viewMassageTitleColorBar"></div>
                  <h2> 錯誤：無此文章 </h2>
                </div><br>';
          echo '<a href="..\..\Frontend\BulletinBoardIndex.php">點擊此處去首頁。</a>';
          exit;
        }
      } else {
        // 此部分是導覽列沒有messageId的情況
        echo '無此文章。<br>';
        echo '<a href="..\..\Frontend\BulletinBoardIndex.php">點擊此處去首頁。</a>';
        exit;
      }

      $user = $message->getUser();
      ?>

      <div class="viewMassageTitle mb-2">

        <div class="viewMassageTitleColorBar"></div>
        <h2 class="animate__animated animate__fadeIn"> <?php echo $message->getTitle() ?> </h2>
      </div>

      <div class="InfoArea mt-4 p-4">
        <div class="authorInfoArea d-flex">
          <div>
            <img class="userPic" src="<?php echo $user->getPicPath() ?>" style="height:100px;border-radius: 5px;">
          </div>
          <div class="authorName ms-4">
            <h5>作者：<?php echo $user->getUserName(); ?> </h5>
            <h>加入時間：<?php echo $user->getDateCreatedAt(); ?> </h>
          </div>
        </div>

      </div>

      <div class="messageInfoArea p-4 mt-3 mb-4">
        <div class="messageCategory">
          <h4>分類：<?php echo $message->getCategory(); ?> </h4>
          <div class="messageTimeArea">
            <div class="messageTime"> 留言時間：<?php echo $message->getDateCreatedAt() ?> </div>
            <div class="messageTime"> 更新時間：<?php echo $message->getDateUpdateAt() ?> </div>
          </div>
        </div>
        <div class="messageContent ps-3 pt-4 ">
          <h3 style="line-height: 1.5;"> <?php echo nl2br($message->getContent()); ?> </h3>
        </div>
      </div>

      <div class="buttonArea">
        <?php
        if ($user->getId() == $_SESSION['userId']) {
          echo '<a type="button" class="btn btn-secondary me-3" href="/Frontend/BulletinBoardUpdateMessage.php?messageId=' . $message->getId() . '">修改</a>';
        } ?>
        <a type="button" class="btn btn-primary  me-3" href="<?php
                                                              //如果存在上一頁則導回上一頁，不存在則導回首頁 
                                                              if (isset($_SERVER['HTTP_REFERER'])) {
                                                                echo $_SERVER['HTTP_REFERER'];
                                                              } else {
                                                                echo '/Frontend/BulletinBoardIndex.php';
                                                              }
                                                              ?>">返回文章列表</a>
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

</body>

</html>