<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/img/icon/favicon.ico" type="" />
  <title>留言板 - 密碼更新</title>

  <?php include 'C:\htdocs\Frontend\fragments\BulletinBoardFrame.php'; ?>

  <!-- CSS -->
  <link rel="stylesheet" href="../CSS/BulletinBoardUpdatePassword.css" />

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

      <div class="updatePasswordTitle">
        <div class="updatePasswordTitleColorBar"></div>
        <h2> 會員密碼更新 </h2>
        <h6 class="ms-4">(修改後需要重新登入)</h6> 
      </div>

      <div class="updatePasswordFormArea mt-4">
        <div class="updatePasswordForm">
          <!---------------- form ---------------->
          <form class="pure-form"  action="../Backend/Service/userService.php" method="post" id="updatePasswordForm">
            <fieldset>
              <!-- 用來分辨要使用哪一個controller方法 -->
              <input type="hidden" name="functionName" value="updatePassword">

              <label for="password">原本的密碼</label>
              <input type="password" id="previousPassword" name="previousPassword" placeholder="請輸入原密碼" class="pure-input-1 mb-4" />
              <label for="newPassword">新密碼</label>
              <input type="password" id="newPassword1" name="newPassword1" placeholder="在此輸入新密碼" class="pure-input-1" />
              <label for="newPassword">確認密碼</label>
              <input type="password" id="newPassword2" name="newPassword2" placeholder="再次輸入新密碼" class="pure-input-1" />

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