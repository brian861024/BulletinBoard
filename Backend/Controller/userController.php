<?php
// 此控制器用於管理用戶之註冊、登入以及修改資料的邏輯

require_once '/htdocs/Backend/Model/dao/userDaoPdo.php';
require_once '/htdocs/Backend/Model/bean/user.php';

class userController
{
    //===========================================================================
    //登入/登出 區域 start
    //1.一般使用者登入
    //邏輯：
    //。先將傳進來的資料做適當的處理
    //。比對驗證碼
    //。輸入之userName是否存在資料庫?存在則比對密碼是否正確，不存在則回傳錯誤訊息
    //。比對密碼是否正確?正確則導入留言版主頁，錯誤則回傳錯誤訊息
    function login()
    {
        session_start();
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $otp = htmlspecialchars($_POST['otp'], ENT_QUOTES, 'UTF-8');
        $password_hash = hash('sha256', $_POST['password']);
        $userDaoPdo = new userDaoPdo;
        // 透過使用者輸入的name來找整個使用者物件
        $user = $userDaoPdo->findUserByUsername_ReturnUserObject($name);

        if ($otp == $_SESSION['otp']) {
            if ($userDaoPdo->findUserByUserName($name)) {
                if ($password_hash == $user->getPassword()) {
                    // 將登入的user資訊放入session
                    $_SESSION['userId'] = $user->getId();
                    $_SESSION['userName'] = $user->getUserName();
                    $_SESSION['userPassword'] = $user->getPassword();
                    $_SESSION['userEmail'] = $user->getEmail();
                    $_SESSION['userPicPath'] = $user->getPicPath();
                    $_SESSION['userDateCreatedAt'] = $user->getDateCreatedAt();
                    $_SESSION['userDateUpdateAt'] = $user->getDateUpdateAt();
                    echo "<script type='text/javascript'>
                alert('登入成功，將前往主頁！');
                </script>";
                    header("refresh:0;url=..\..\Frontend\BulletinBoardIndex.php");
                    exit;
                } else {
                    // 存在使用者，把使用者名稱放至SESSION以利前端預設輸入
                    $_SESSION['userName'] =  $user->getUserName();
                    echo "<script type='text/javascript'>
                alert('密碼錯誤');
                </script>";
                    header("refresh:0;url=..\..\Frontend\BulletinBoardLogin.php");
                    exit;
                }
            } else {
                echo "<script type='text/javascript'>
            alert('查無使用者');
            </script>";
                header("refresh:0;url=..\..\Frontend\BulletinBoardLogin.php");
                exit;
            }
        } else {
            $_SESSION['userName'] =  $user->getUserName();
            echo "<script type='text/javascript'>
            alert('驗證碼輸入錯誤');
            </script>";
            header("refresh:0;url=..\..\Frontend\BulletinBoardLogin.php");
            exit;
        }
    }

    //2.一般使用者登出
    //邏輯：
    //。確認SESSION裡存在使用者
    //。清除SESSION
    function logout()
    {
        session_start();
        if (isset($_SESSION['userId'])) {
            session_destroy();
            echo "<script type='text/javascript'>
            alert('登出成功！');
            </script>";
            header("refresh:0;url=..\..\Frontend\BulletinBoardLogin.php");
            exit;
        }
    }

    //登入/登出 區域 end
    //===========================================================================
    //註冊 區域 start
    //1.一般會員註冊
    //邏輯：
    //。先將傳進來的資料做適當的處理
    //。比對驗證碼
    //。檢查使用者名稱是否小於20
    //。檢查使用者名稱是否未含有中文跟特殊符號
    //。檢查密碼是否長度為4
    //。檢查密碼是否含中文跟特殊符號
    //。比對兩次輸入之密碼是否一致
    //。比對使用者名稱是否有重複
    //。比對使用者信箱是否有重複
    //。建立一個user物件來儲存使用者輸入之資料並且傳至Dao作寫入
    function register()
    {
        session_start();
        // htmlspecialchars() 函数把一些预定义的字符转换为 HTML 实体。
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $email =  htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
        $otp = htmlspecialchars($_POST['otp'], ENT_QUOTES, 'UTF-8');
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];
        $password1_hash = hash('sha256', $password1);
        $password2_hash = hash('sha256', $password2);
        $userDaoPdo = new userDaoPdo;

        if ($otp == $_SESSION['otp']) {
            // 檢查使用者名稱是否小於20
            if (strlen($name) < 20) {
                // 檢查使用者名稱沒有含中文跟特殊符號
                if (!preg_match('/[\x{4e00}-\x{9fa5}]|[^A-Za-z0-9]/u', $name)) {
                    if (strlen($password1) == 4) {
                        if (!preg_match('/[\x{4e00}-\x{9fa5}]|[^A-Za-z0-9]/u', $password1)) {
                            //。比對兩次輸入的密碼是否相同
                            if ($password1_hash == $password2_hash) {
                                //。比對前端輸入的使用者名稱是否和資料庫的有重複
                                if ($userDaoPdo->findUserByUserName($name)) {
                                    // 當發生錯誤的時候，原本輸入的預存到session，再在前端提取
                                    unset($_SESSION['registerName']);
                                    $_SESSION['registerEmail'] = $email;
                                    $_SESSION['$registerPassword1'] = $password1;
                                    $_SESSION['$registerPassword2'] = $password2;
                                    echo "<script type='text/javascript'>
                                    alert('使用者名稱已存在');
                                    </script>";
                                    header("refresh:0;url=..\..\Frontend\BulletinBoardRegister.php");
                                    exit;
                                } else {
                                    //。比對前端輸入的使用者信箱是否和資料庫的有重複
                                    if ($userDaoPdo->findUserByEmail($email)) {
                                        $_SESSION['registerName'] = $name;
                                        unset($_SESSION['registerEmail']);
                                        $_SESSION['$registerPassword1'] = $password1;
                                        $_SESSION['$registerPassword2'] = $password2;
                                        echo "<script type='text/javascript'>
                                        alert('信箱已註冊');
                                        </script>";
                                        header("refresh:0;url=..\..\Frontend\BulletinBoardRegister.php");
                                        exit;
                                    } else {
                                        //。建立一個user物件來儲存使用者輸入之資料並且傳至Dao作寫入
                                        $user = new user;
                                        $user->setUserName($name);
                                        $user->setPassword($password1_hash);
                                        $user->setEmail($email);
                                        $userDaoPdo->addUser($user);
                                        echo "<script type='text/javascript'>
                                        alert('已註冊。您將回到登入頁面。');
                                        </script>";
                                        session_destroy();
                                        header("refresh:0;url=..\..\Frontend\BulletinBoardLogin.php");
                                        exit;
                                    }
                                }
                            } else {
                                $_SESSION['registerName'] = $name;
                                $_SESSION['registerEmail'] = $email;
                                unset($_SESSION['$registerPassword1']);
                                unset($_SESSION['$registerPassword2']);
                                echo "<script type='text/javascript'>
                                alert('兩次密碼不相同');
                                </script>";
                                header("refresh:0;url=..\..\Frontend\BulletinBoardRegister.php");
                                exit;
                            }
                        } else {
                            $_SESSION['registerName'] = $name;
                            $_SESSION['registerEmail'] = $email;
                            unset($_SESSION['$registerPassword1']);
                            unset($_SESSION['$registerPassword2']);
                            echo "<script type='text/javascript'>
                            alert('密碼包含中文或特殊符號');
                            </script>";
                            header("refresh:0;url=..\..\Frontend\BulletinBoardRegister.php");
                            exit;
                        }
                    } else {
                        $_SESSION['registerName'] = $name;
                        $_SESSION['registerEmail'] = $email;
                        unset($_SESSION['$registerPassword1']);
                        unset($_SESSION['$registerPassword2']);
                        echo "<script type='text/javascript'>
                        alert('密碼長度不符');
                        </script>";
                        header("refresh:0;url=..\..\Frontend\BulletinBoardRegister.php");
                        exit;
                    }
                } else {
                    unset($_SESSION['registerName']);
                    $_SESSION['registerEmail'] = $email;
                    $_SESSION['$registerPassword1'] = $password1;
                    $_SESSION['$registerPassword2'] = $password2;
                    echo "<script type='text/javascript'>
                    alert('使用者名稱包含中文或特殊符號');
                    </script>";
                    header("refresh:0;url=..\..\Frontend\BulletinBoardRegister.php");
                    exit;
                }
            } else {
                unset($_SESSION['registerName']);
                $_SESSION['registerEmail'] = $email;
                $_SESSION['$registerPassword1'] = $password1;
                $_SESSION['$registerPassword2'] = $password2;
                echo "<script type='text/javascript'>
                alert('使用者名稱超過20字');
                </script>";
                header("refresh:0;url=..\..\Frontend\BulletinBoardRegister.php");
                exit;
            }
        } else {
            $_SESSION['registerName'] = $name;
            $_SESSION['registerEmail'] = $email;
            $_SESSION['$registerPassword1'] = $password1;
            $_SESSION['$registerPassword2'] = $password2;
            echo "<script type='text/javascript'>
            alert('驗證碼輸入錯誤');
            </script>";
            header("refresh:0;url=..\..\Frontend\BulletinBoardRegister.php");
            exit;
        }
    }
    //註冊 區域 end
    //===========================================================================
    //修改資訊 區域 start
    //1.一般會員修改密碼
    //邏輯：
    //。先將傳進來的資料做適當的處理
    //。比對舊密碼是否正確
    //。比對新密碼是否一致
    //。比對舊密碼和新密碼是否相同
    //。將新密碼設定至資料庫
    function updatePassword()
    {
        $previousPassword_hash = hash('sha256', $_POST['previousPassword']);
        $newPassword1 = $_POST['newPassword1'];
        $newPassword2 = $_POST['newPassword2'];
        $password1_hash = hash('sha256', $_POST['newPassword1']);
        $password2_hash = hash('sha256', $_POST['newPassword2']);
        $userDaoPdo = new userDaoPdo;
        session_start();
        //。比對舊密碼是否正確
        if (strlen($newPassword1) == 4) {
            if (!preg_match('/[\x{4e00}-\x{9fa5}]|[^A-Za-z0-9]/u', $newPassword1)) {
                if ($previousPassword_hash == $_SESSION['userPassword']) {
                    //。比對新密碼是否一致
                    if ($password1_hash == $password2_hash) {
                        //。比對舊密碼和新密碼是否相同
                        if ($previousPassword_hash != $password1_hash) {
                            //。將新密碼設定至資料庫
                            $userDaoPdo->updatePasswordById($_SESSION['userId'], $password1_hash);
                            echo "<script type='text/javascript'>
                            alert('密碼更新成功，請用新密碼重新登入');
                            </script>";
                            session_destroy();
                            header("refresh:0;url=..\..\Frontend\BulletinBoardLogin.php");
                            exit;
                        } else {
                            echo "<script type='text/javascript'>
                            alert('原密碼與新密碼相同！');
                            </script>";
                            header("refresh:0;url=..\..\Frontend\BulletinBoardUpdatePassword.php");
                            exit;
                        }
                    } else {
                        echo "<script type='text/javascript'>
                        alert('新密碼兩次輸入不一致');
                        </script>";
                        header("refresh:0;url=..\..\Frontend\BulletinBoardUpdatePassword.php");
                        exit;
                    }
                } else {
                    echo "<script type='text/javascript'>
                    alert('原密碼輸入錯誤');
                    </script>";
                    header("refresh:0;url=..\..\Frontend\BulletinBoardUpdatePassword.php");
                    exit;
                }
            } else {
                echo "<script type='text/javascript'>
                alert('密碼包含中文或特殊符號');
                </script>";
                header("refresh:0;url=..\..\Frontend\BulletinBoardUpdatePassword.php");
            }
        } else {
            echo "<script type='text/javascript'>
            alert('密碼長度不符');
            </script>";
            header("refresh:0;url=..\..\Frontend\BulletinBoardUpdatePassword.php");
        }
    }

    //2.一般會員修改信箱
    //邏輯：
    //。先將傳進來的資料做適當的處理
    //。比對舊信箱是否正確
    //。比對舊信箱和新信箱是否相同
    //。比對新信箱是否存在
    //。將新信箱設定至資料庫
    function updateEmail()
    {
        $previousEmail = htmlspecialchars($_POST['previousEmail'], ENT_QUOTES, 'UTF-8');
        $newEmail = htmlspecialchars($_POST['newEmail'], ENT_QUOTES, 'UTF-8');
        $userDaoPdo = new userDaoPdo;
        session_start();
        //。比對舊信箱是否正確
        if ($previousEmail == $_SESSION['userEmail']) {
            //。比對舊信箱和新信箱是否相同
            if ($userDaoPdo->findUserByEmail($newEmail)) {
                echo "<script type='text/javascript'>
                alert('新信箱已存在');
                </script>";
                header("refresh:0;url=..\..\Frontend\BulletinBoardUpdateEmail.php");
                exit;
            } else {
                if ($previousEmail != $newEmail) {
                    //。將新信箱設定至資料庫
                    $userDaoPdo->updateEmailById($_SESSION['userId'], $newEmail);
                    echo "<script type='text/javascript'>
                    alert('信箱更新成功，將重導至首頁。');
                    </script>";
                    header("refresh:0;url=..\..\Frontend\BulletinBoardIndex.php");
                    exit;
                } else {
                    echo "<script type='text/javascript'>
                    alert('新信箱與原信箱相同');
                    </script>";
                    header("refresh:0;url=..\..\Frontend\BulletinBoardUpdateEmail.php");
                    exit;
                }
            }
        } else {
            echo "<script type='text/javascript'>
            alert('原信箱輸入錯誤');
            </script>";
            header("refresh:0;url=..\..\Frontend\BulletinBoardUpdateEmail.php");
            exit;
        }
    }

    //3.一般會員上傳頭貼
    //。檢查後綴名是否為圖檔
    //。重新為圖檔命名
    //。把檔案從預設路徑放置到設定路徑
    //。用絕對路徑讀不到檔案，所以用相對路徑更新資料庫路徑和session路徑
    function updatePic()
    {
        $file = $_FILES['userPic'];
        $userDaoPdo = new userDaoPdo;
        session_start();
        // 取出檔案的後綴名
        $ext = strrchr($file['name'], '.');
        // 比對後綴名是否為以下
        if (preg_match('/\.png|\.img|\.jpg|\.jpeg/', $ext)) {
            // 給予檔案一個新名字，隨機的四碼加當前時間
            $newName = mt_rand(0000, 9999) . time() . $ext;
            // 設定路徑
            $setPath = 'C:\htdocs\img\pic\\' . $newName;
            // 把檔案從預設路徑放置到設定路徑
            move_uploaded_file($file['tmp_name'], $setPath);
            // 用絕對路徑讀不到檔案，所以用相對路徑來抓
            $path = '/img/pic/' . $newName;
            // 用Dao把資料庫的路徑資料更新
            $userDaoPdo->updateUserPicById($_SESSION['userId'], $path);
            // 存放到session，可以即時更新更換後的圖像
            $_SESSION['userPicPath'] = $path;
            header("refresh:0;url=..\..\Frontend\BulletinBoardUserInfo.php");
        } else {
            echo "<script type='text/javascript'>
            alert('上傳檔案格式錯誤');
            </script>";
            header("refresh:0;url=..\..\Frontend\BulletinBoardUserInfo.php");
            exit;
        }
    }

    //修改資訊 區域 end
    //===========================================================================
}
