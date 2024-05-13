<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/img/icon/favicon.ico" type="" />
  <title>留言板 - 新增留言</title>

  <?php include 'C:\htdocs\Frontend\fragments\BulletinBoardFrame.php'; ?>

  <!-- CSS -->
  <link rel="stylesheet" href="../CSS/BulletinBoardNewMessage.css" />

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

      <div class="newMassageTitle mb-2">
        <div class="newMassageTitleColorBar"></div>
        <h2> 新留言 </h2>
      </div>

      <div class="newMassageFormArea">
        <!---------------- form ---------------->
        <form class="pure-form pure-form-aligned" action="../Backend/Service/messageService.php" method="post" id="newMessageForm">
          <fieldset class="pure-group">
            <!-- 用來分辨要使用哪一個controller方法 -->
            <input type="hidden" name="functionName" value="newMessage">

            <input type="text" class="pure-input-1 mt-2" name="messageTitle" id="messageTitle" placeholder="留言標題" value="<?php
            session_start();
            if(isset($_SESSION['messageTitle'])){
              echo $_SESSION['messageTitle'];
            }
            ?>" />
            <br>
            <select class="mb-4" name="categoryId" id="categoryId">
              <option value="1">心情</option>
              <option value="2">工作</option>
              <option value="3">感情</option>
              <option value="4">運動</option>
              <option value="5">星座</option>
              <option value="6">遊戲</option>
              <option value="7">閒聊</option>
            </select>
            <textarea class="pure-input-1 mb-2" name="messageContent" id="messageContent" placeholder="留言輸入區" style="height: 400px ;min-height: 100px;max-height: 400px"><?php 
            if(isset($_SESSION['messageContent'])){
              echo $_SESSION['messageContent'];
            }
            ?></textarea>
          </fieldset>
          <button type="submit" class="pure-button pure-input-1 pure-button-primary">送出</button>
        </form>
        <!---------------- form ---------------->
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