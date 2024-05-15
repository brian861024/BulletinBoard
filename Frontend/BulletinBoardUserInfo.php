<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/img/icon/favicon.ico" type="" />
  <title>留言板 - 會員中心</title>

  <?php include 'C:\htdocs\Frontend\fragments\BulletinBoardFrame.php'; ?>

  <!-- CSS -->
  <link rel="stylesheet" href="../CSS/BulletinBoardUserInfo.css" />

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

    <?php include 'C:/htdocs/Frontend/fragments/BulletinBoardUserInfoLeftNavbar.php'; ?>

    <!-- 右側內容區域 -->
    <div class="rightSectionArea">

      <?php

      $userId = $_SESSION['userId'];
      $userName = $_SESSION['userName'];
      $userEmail = $_SESSION['userEmail'];
      $userPicPath = $_SESSION['userPicPath'];
      $userDateCreatedAt = $_SESSION['userDateCreatedAt'];
      $userDateUpdateAt = $_SESSION['userDateUpdateAt'];
      ?>

      <div class="updateEmailTitle mb-4">
        <div class="updateEmailTitleColorBar"></div>
        <h2 class="animate__animated animate__fadeIn"> 會員資訊 </h2>
      </div>

      <div>
        <img class="userPic" src="<?php echo $userPicPath ?>" style="height:200px;border-radius: 5px;">
      </div>

      <!-- 上傳頭貼區域 -->
      <div class="updateEmailFormArea mt-4">
        <div class="updateEmailForm">
          <!---------------- form ---------------->
          <form class="pure-form" action="../Backend/Service/userService.php" method="post" id="updateEmailForm" enctype="multipart/form-data">
            <fieldset>
              <!-- 用來分辨要使用哪一個controller方法 -->
              <input type="hidden" name="functionName" value="updatePic">
              <!-- 傳送使用者id -->
              <input type="hidden" name="userId" value="<?php echo $userId ?>">

              <h5 for="file">更新頭貼</h5>
              <input type="file" id="userPic" name="userPic" class="pure-input-1" />
              <button type="submit" class="pure-button mt-2">上傳檔案</button>
            </fieldset>
          </form>
          <!---------------- form ---------------->
        </div>
      </div>
      <div class="mt-3">
        <h5>用戶編號 ： <?php echo "$userId"; ?></h5>
      </div>
      <div class="mt-3">
        <h5>使用者名稱 ： <?php echo "$userName"; ?></h5>
      </div>
      <div class="mt-3">
        <h5>使用者信箱 ： <?php echo "$userEmail"; ?></h5>
      </div>
      <div class="mt-3">
        <h5>會員創建於 ： <?php echo "$userDateCreatedAt"; ?></h5>
      </div>
      <div class="mt-3">
        <h5>資訊更新於 ： <?php echo "$userDateUpdateAt"; ?></h5>
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