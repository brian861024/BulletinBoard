<?php

session_start();
$userName = $_SESSION['userName'];

if(isset($userName)){
echo '
    <form class="pure-form pure-form-aligned" action="../Backend/Service/userService.php" method="post" id="logoutForm"  style = "display:none;">
    <!-- 用來分辨要使用哪一個controller方法 -->
    <input type="hidden" name="functionName" value="logout">
    </form>

    <script>
    function logout() {
      document.getElementById("logoutForm").submit();
    }
    </script>

    <!-- Header左側logo圖片 -->

    <div class="logo">
      <a href="../Frontend/BulletinBoardIndex.php"><img src="/img/icon/logo.png" class="logoimg"></a>
    </div>

    <!-- Header右側按鍵 -->

    <nav class="navbar navbar-expand-lg navbar-light bg-opacity fs-4">
      <div class="container-fluid">
        <a class="navbar-brand fs-1 mx-5" href="../Frontend/BulletinBoardIndex.php">留言板</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="../Frontend/BulletinBoardNewMessage.php">新增留言</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../Frontend/BulletinBoardHistoryMessage.php">歷史留言</a>
            </li>
            <li class="nav-item dropdown"  href="../Frontend/BulletinBoardUserInfo.php">
              <a class="nav-link dropdown-toggle ms-3"  id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              會員中心
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item fs-5" href="../Frontend/BulletinBoardUserInfo.php">會員資訊</a></li>
                <li><a class="dropdown-item fs-5" href="../Frontend/BulletinBoardUpdateEmail.php">信箱修改</a></li>
                <li><a class="dropdown-item fs-5" href="../Frontend/BulletinBoardUpdatePassword.php">密碼修改</a></li>
                <hr>
                <li><a class="dropdown-item fs-5" onclick="logout()"> 登出 </a></li>
              </ul>
            </.li>
            <li class="nav-item ms-4">
            <a class="nav-link">' . $userName . '，你好</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
';
} else {
  echo "<script type='text/javascript'>
  alert('請先登入！');
  </script>";
  header("refresh:0;url=..\..\Frontend\BulletinBoardLogin.php");
}
