<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/img/icon/favicon.ico" type="" />
    <title>留言板 - 登入介面</title>

    <?php include 'C:\htdocs\Frontend\fragments\BulletinBoardFrame.php'; ?>

    <!-- CSS -->
    <link rel="stylesheet" href="../CSS/BulletinBoardLogin.css" />

</head>

<body>
    <!--===========================================================================-->
    <!--Container 區域 start-->
    <container>
        <div class="loginFormArea">
            <div class="loginform">
                <!---------------- form ---------------->
                <form class="pure-form pure-form-aligned" action="../Backend/Service/userService.php" method="post" id="loginForm">
                    <fieldset>
                        <!-- 用來分辨要使用哪一個controller方法 -->
                        <input type="hidden" name="functionName" value="login">

                        <div class="pure-control-group">
                            <label for="name" style="text-align:left; padding-left: 10PX;">用戶名稱</label>
                            <input type="text" id="name" name="name" class="pure-input-2-3" placeholder="Username" value = "<?php
                            // 密碼輸入錯誤後會自動帶入使用者名稱
                            session_start();
                            if(isset($_SESSION['userName'])){
                                echo $_SESSION['userName'];
                            }
                            ?>"
                            required />
                        </div>
                        <div class="pure-control-group">
                            <label for="password" style="text-align:left; padding-left: 10PX;">密碼</label>
                            <input type="password" id="password" name="password" class="pure-input-2-3" placeholder="Password" required />
                        </div>
                    </fieldset>
                </form>
                <!---------------- form ---------------->
            </div>
            <div class="ButtonArea">
                <div class="Button">
                    <button type="submit" class="pure-button" form="loginForm">登入</button>
                </div>
                <div class="Button">
                    <button onclick="window.location.href='./BulletinBoardRegister.php'" class="pure-button">註冊</button>
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