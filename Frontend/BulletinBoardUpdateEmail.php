<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/img/icon/favicon.ico" type="" />
  <title>留言板 - 信箱更新</title>

  <?php include 'C:\htdocs\Frontend\fragments\BulletinBoardFrame.php'; ?>

  <!-- CSS -->
  <link rel="stylesheet" href="../CSS/BulletinBoardUpdateEmail.css" />

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

      <div class="updateEmailTitle">
        <div class="updateEmailTitleColorBar"></div>
        <h2> 會員信箱更新 </h2>
      </div>

      <div class="updateEmailFormArea mt-4">
        <div class="updateEmailForm">
          <!---------------- form ---------------->
          <form class="pure-form" action="../Backend/Service/userService.php" method="post" id="updateEmailForm">
            <fieldset>
              <!-- 用來分辨要使用哪一個controller方法 -->
              <input type="hidden" name="functionName" value="updateEmail">

              <label for="email">原本的信箱</label>
              <input type="email" id="previousEmail" name="previousEmail" placeholder="請輸入原信箱" class="pure-input-1 mb-4" />
              <label for="newEmail">新信箱</label>
              <input id="newEmail" name="newEmail" placeholder="在此輸入新信箱" class="pure-input-1" />

              <button type="submit" class="pure-button mt-5">提交</button>
            </fieldset>
          </form>
          <!---------------- form ---------------->
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

</body>

</html>