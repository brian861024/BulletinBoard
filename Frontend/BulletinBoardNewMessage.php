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

<body onload="runOnloadFunction()">
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

            當前字數：<label id="countTitle"></label>
            <input type="text" class="pure-input-1 mt-2" name="messageTitle" id="messageTitle" placeholder="留言標題 ( 上限 30 字 )" value="<?php
                                                                                                                                      if (isset($_SESSION['messageTitle'])) {
                                                                                                                                        echo $_SESSION['messageTitle'];
                                                                                                                                      }
                                                                                                                                      ?>" />
            <br>
            <select class="mb-2" name="categoryId" id="categoryId">
              <option value="1">心情</option>
              <option value="2">工作</option>
              <option value="3">感情</option>
              <option value="4">運動</option>
              <option value="5">星座</option>
              <option value="6">遊戲</option>
              <option value="7">閒聊</option>
            </select>
            <br>
            當前字數：<label id="countContent"></label>
            <textarea class="pure-input-1 mb-2" name="messageContent" id="messageContent" placeholder="留言輸入區 ( 上限 300 字 )" style="height: 400px ;min-height: 100px;max-height: 400px"><?php
                                                                                                                                                                                      if (isset($_SESSION['messageContent'])) {
                                                                                                                                                                                        echo $_SESSION['messageContent'];
                                                                                                                                                                                      }
                                                                                                                                                                                      ?></textarea>
          </fieldset>
          <button type="button" class="pure-button pure-input-1 pure-button-primary" onclick="submitNewMessageForm()">送出</button>
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

  <script>
    function submitNewMessageForm() {
      if (messageContent.value.length <= 300) {
        if (messageTitle.value.length <= 20) {
          document.getElementById("newMessageForm").submit();
        } else {
          alert('標題長度不符');
          return false;
        }
      } else {
        alert('內容長度不符');
        return false;
      }
    }

    function runOnloadFunction() {
      countContentChar();
      countTitleChar();
    }

    function countContentChar() {
      //允許輸入最大長度
      var intMaxLength = 300;
      //文字輸入//取得計算字數的物件塊
      var messageContent = document.getElementById("messageContent");
      //取得計算字數的物件 
      var countContent = document.getElementById("countContent");
      //將文字輸入方塊表度寫入顯示Label
      countContent.innerHTML = messageContent.value.length;
      //比對字數是否超過允許長度
      if (messageContent.value.length > intMaxLength) {
        countContent.innerHTML = messageContent.value.length + '，留言上限為300字，已超過';
        countContent.classList.add("text-danger");
      } else {
        countContent.classList.remove("text-danger");
      }
      //250毫秒後再執行一次此function
      setTimeout("countContentChar()", 250);
    }

    function countTitleChar() {
      //允許輸入最大長度
      var intMaxLength = 20;
      //文字輸入//取得計算字數的物件塊
      var messageTitle = document.getElementById("messageTitle");
      //取得計算字數的物件 
      var countTitle = document.getElementById("countTitle");
      //將文字輸入方塊表度寫入顯示Label
      countTitle.innerHTML = messageTitle.value.length;
      //比對字數是否超過允許長度
      if (messageTitle.value.length > intMaxLength) {
        countTitle.innerHTML = messageTitle.value.length + '，標題上限為20字，已超過';
        countTitle.classList.add("text-danger");
      } else {
        countTitle.classList.remove("text-danger");
      }
      //250毫秒後再執行一次此function
      setTimeout("countTitleChar()", 250);
    }

    window.onload = runOnloadFunction;
  </script>

</body>

</html>