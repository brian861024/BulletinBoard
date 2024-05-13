<?php

function creatOTP()
{
    session_start();
    // 生成驗證碼
    $randomNumber = mt_rand(1000, 9999);
    $_SESSION['otp'] = $randomNumber;

    // 建立圖片
    $image = imagecreatetruecolor(100, 40);

    // 設置顏色
    $backgroundColor = imagecolorallocate($image, 37 , 100, 120);
    $textColor = imagecolorallocate($image, 193, 202, 234);
    $lineColor = imagecolorallocate($image, 8, 12, 18); // 干擾線條顏色

    // 填充背景色
    imagefilledrectangle($image, 0, 0, 100, 40, $backgroundColor);

    // 寫入文本
    imagestring($image, 5, 15, 15, $randomNumber, $textColor);

    // 添加干擾線條
    for ($i = 0; $i < 6; $i++) {
        imageline($image, mt_rand(0, 120), mt_rand(0, 50), mt_rand(0, 120), mt_rand(0, 50), $lineColor);
    }

    // 設置標頭
    header('Content-Type: image/png');

    // 輸出圖片
    imagepng($image);

    // 釋放資源
    imagedestroy($image);
}

// 調用函數生成圖片
creatOTP();
