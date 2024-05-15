<?php require '../Backend/Controller/messageController.php'; ?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/img/icon/favicon.ico" type="" />
  <title>留言板 - 歷史留言</title>

  <?php include 'C:\htdocs\Frontend\fragments\BulletinBoardFrame.php'; ?>

  <!-- CSS -->
  <link rel="stylesheet" href="../CSS/BulletinBoardHistoryMessage.css" />

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
    <div class="rightSectionArea animate__animated animate__fadeIn">

      <div class="historyMessageCardArea">

        <!-- 歷史留言區域 -->
        <?php
        $messageDaoPdo = new messageDaoPdo();
        $messageController = new messageController();
        // 先找出想顯示的所有留言以便於計算總數
        $messageNums = count($messageDaoPdo->findHistoryMessages($_SESSION['userId']));
        // 呼叫controller裡面的頁數控制器，控制器回傳包含總頁數、起始頁數跟當前頁面起始留言的陣列
        $pageData = $messageController->getpages($messageNums, 4);
        // 根據當前頁面起始留言跟一頁要顯示幾個留言來決定當前頁面要顯示的留言
        $messages = $messageDaoPdo->findHistoryMessagesByPage($_SESSION['userId'], $pageData['startMessage'], 4);
        
        if ($messages) {
          foreach ($messages as $message) {
            echo ' 
          <div class="historyMessageCard mb-4">
            <h5 class="card-header">' . $message->getTitle() . '</h5>
            <div class="card-body mb-3">
              <p id="content" class="card-text">' . $message->getContent() . '</p>
              <div style="text-align: right;">
              <a href="/Frontend/BulletinBoardUpdateMessage.php?messageId='. $message->getId() .'" class="btn btn btn-secondary">修改</a>
              <a href="\Frontend\BulletinBoardViewMessage.php?messageId='. $message->getId() .'" class="btn btn-primary ms-2">查看更多</a>
              </div>
            </div>
          </div>
          ';
          }
        } else {
          echo '<p>您尚未留言。</p>';
        }
        ?>

      </div>
      <?php

        $totalPages = $pageData['totalPages'];
        $currentPage = $pageData['currentPage'];
        
        echo '<div class="pageNavArea">
          <nav aria-label="Page navigation">
            <ul class="pagination">
              <li class="page-item"><a class="page-link" href="?page=' . max(1, $currentPage - 1) . '">Previous</a></li>';
              for ($i = 1; $i <= $totalPages; $i++) {
                if ($currentPage - 3 < $i && $i < $currentPage + 3) {
                  echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                }
              }
              echo '<li class="page-item"><a class="page-link" href="?page=' . min($totalPages, $currentPage + 1) . '">Next</a></li>
            </ul>
          </nav>
        </div>';
        ?>
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

  <script>
    function limitText(contents, limit) {
      // 把所有的元素都集合起來
      var contents = document.querySelectorAll(contents);
      // 用foreach處理每一個元素
      contents.forEach(function(content) {
        var text = content.innerText;
        if (text.length > limit) {
          var limitedText = text.slice(0, limit) + '...'; 
          content.innerText = limitedText;
        }
      });
    }

    window.onload = function() {
      limitText('#content', 50); 
    };
  </script>

</body>

</html>