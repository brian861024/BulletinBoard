<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/img/icon/favicon.ico" type="" />
    <title>留言板 - 註冊介面</title>

    <?php include 'C:\htdocs\Frontend\fragments\BulletinBoardFrame.php'; ?>

    <!-- CSS -->
    <link rel="stylesheet" href="../CSS/BulletinBoardRegister.css" />

</head>

<body>
    <!--===========================================================================-->
    <!--Container 區域 start-->
    <container>
        <div class="registerFormArea">
            <div class="registerForm">
                <!---------------- form ---------------->
                <form class="pure-form pure-form-aligned" action="../Backend/Service/userService.php" method="post" id="registerForm">

                    <fieldset>
                        <!-- 用來分辨要使用哪一個controller方法 -->
                        <input type="hidden" name="functionName" value="register">
                        <?php session_start(); ?>
                        <div class="pure-control-group">
                            <label for="aligned-name" style="text-align:left; padding-left: 10PX;">用戶名稱</label>
                            <input type="text" id="name" name="name" class="pure-input-2-3" placeholder="Username" value="<?php if(isset($_SESSION['registerName'])){echo $_SESSION['registerName'];} ?>" required />
                        </div>
                        <div class="pure-control-group">
                            <label for="aligned-password" style="text-align:left; padding-left: 10PX;">密碼</label>
                            <input type="password" id="password1" name="password1" class="pure-input-2-3" placeholder="Password" value="<?php if(isset($_SESSION['registerPassword1'])){echo $_SESSION['registerPassword1'];} ?>" required />
                        </div>
                        <div class="pure-control-group">
                            <label for="aligned-password" style="text-align:left; padding-left: 10PX;">確認密碼</label>
                            <input type="password" id="password2" name="password2" class="pure-input-2-3" placeholder="Password" value="<?php if(isset($_SESSION['registerPassword2'])){echo $_SESSION['registerPassword2'];} ?>" required />
                        </div>
                        <div class="pure-control-group" style="margin-top:20PX ;">
                            <label for="aligned-email" style="text-align:left; padding-left: 10PX;">信箱</label>
                            <input type="email" id="email" name="email" class="pure-input-2-3" placeholder="E-mail" value="<?php if(isset($_SESSION['registerEmail'])){echo $_SESSION['registerEmail'];} ?>" required />
                        </div>
                    </fieldset>
                    
                </form>
                <!---------------- form ---------------->
            </div>
            <div class="ButtonArea">
                <div class="Button">
                    <button onclick="window.location.href='./BulletinBoardLogin.php'" class="pure-button">返回登入</button>
                </div>
                <div class="Button">
                    <button type="submit" class="pure-button" form="registerForm" id="submitRegisterForm">註冊</button>
                </div>

            </div>
        </div>
    </container>
    <!--Container 區域 end-->
    <!--===========================================================================-->
    <!--Footer 區域 start-->
    <footer>

        <?php include 'C:\htdocs\Frontend\fragments\BulletinBoardFooter.php'; ?>

    </footer>
    <!--Footer 區域 end-->
    <!--===========================================================================-->
</body>



</html>