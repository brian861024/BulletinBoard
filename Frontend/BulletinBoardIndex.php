<?php require '../Backend/Controller/messageController.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/img/icon/favicon.ico" type="" />
  <title>留言板 - 主頁</title>

  <?php include 'C:\htdocs\Frontend\fragments\BulletinBoardFrame.php'; ?>

  <!-- CSS -->
  <link rel="stylesheet" href="../CSS/BulletinBoardIndex.css" />

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

      <!-- 上方搜索列表 -->
      <div class="searchArea">
        <div class="MessageTitle ms-5 ps-3">
          <div class="MessageTitleColorBar"></div>
          <h2>

            <?php
            $categoryDaoPdo = new categoryDaoPdo;
            if (isset($_GET["categoryId"])) {
              $categorySum = $categoryDaoPdo->countAllCategories();
              if ($_GET["categoryId"] > $categorySum) {
                echo '錯誤：不存在之分類';
              } else {
                if ($_GET["categoryId"] <= 0) {
                  echo '錯誤：不存在之分類';
                } else {
                  // 如果get裡面有category那就顯示分類
                  if (isset($_GET["categoryId"])) {
                    $category = $categoryDaoPdo->findCategoryById($_GET["categoryId"]);
                    echo $category;
                  }
                }
              }
            } else {
              echo '所有留言';
            }

            ?>

          </h2>
        </div>

        <?php
        // 暫時沒開發分類+關鍵字的搜索功能，所以在分類的頁面把搜索欄拿掉
        if (isset($_GET["categoryId"])) {
        } else {
          echo '
                  <!-- 右邊搜索欄 -->
                  <div class="search">
                    <form class="d-flex" method="GET" action="">
                      <input class="form-control me-5" type="search" name="searchQuery" placeholder="Search" aria-label="Search"
                      value="';
          // 如果有搜索資料就帶入
          if (isset($_GET["searchQuery"])) {
            echo $_GET["searchQuery"];
          }
          echo '">
                      <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>
                  </div>';
        }
        ?>

      </div>

      <!-- 下方文章列表 區域 Start -->
      <div class="messageArea">

        <?php
        // =============== 查找留言區域 ===============
        $messageDaoPdo = new messageDaoPdo();
        $messageController = new messageController();
        // 如果get有搜索資料那糾先依照搜索資料來顯示
        if (isset($_GET["searchQuery"])) {
          $messageNums = count($messageDaoPdo->findMessagesByKeyWord($_GET["searchQuery"]));
          // 呼叫controller裡面的頁數控制器，控制器回傳包含總頁數、起始頁數跟當前頁面起始留言的陣列
          $pageData = $messageController->getpages($messageNums, 12);
          // 根據當前頁面起始留言跟一頁要顯示幾個留言來決定當前頁面要顯示的留言
          $messages = $messageDaoPdo->findMessagesByKeyWordAndPage($_GET["searchQuery"], $pageData['startMessage'], 12);
        } else {
          // 如果get有分類id那就先依照id來顯示
          if (isset($_GET["categoryId"])) {
            $messageNums = count($messageDaoPdo->findMessagesByCategoryId($_GET["categoryId"]));
            $pageData = $messageController->getpages($messageNums, 12);
            $messages = $messageDaoPdo->findMessagesByCategoryIdAndPage($_GET["categoryId"], $pageData['startMessage'], 12);
          } else {
            // 顯示所有留言
            $messageNums = count($messageDaoPdo->findMessages());
            $pageData = $messageController->getpages($messageNums, 12);
            $messages = $messageDaoPdo->findMessagesByPage($pageData['startMessage'], 12);
          }
        }
        // =============== 查找留言區域 ===============
        // =============== 顯示留言區域 ===============
        // 如果有分類就要跑以下判斷
        if (isset($_GET["categoryId"])) {
          // 拿到分類的總數和輸入的分類ID比較
          if ($_GET["categoryId"] > $categorySum) {
            echo '<a href="..\..\Frontend\BulletinBoardIndex.php">點擊此處去首頁。</a>';
            exit;
          } else {
            //  確保分類id不小於零
            if ($_GET["categoryId"] <= 0) {
              echo '<a href="..\..\Frontend\BulletinBoardIndex.php">點擊此處去首頁。</a>';
              exit;
            }
          }
        }
        // 都通過則顯示留言
        if ($messages) {
          foreach ($messages as $message) {
            $user = $message->getUser();
            echo ' 
              <div class="card m-3" style="width: 18rem;">
                  <h6 class="me-3 mt-3" style="text-align: right;">' . $message->getCategory() . '</h6>
                <div class="card-body">
                  <h4 class="card-title mb-3">' . $message->getTitle() . '</h4>
                  <h6 class="ms-2 mb-4">by ' . $user->getUserName() . '</h6>
                  <h5 id="content" class="card-text mb-3">' . $message->getContent() . '</h5>
                  <a href="\Frontend\BulletinBoardViewMessage.php?messageId=' . $message->getId() . '" class="btn btn-primary">查看更多</a>
                </div>
              </div>
              ';
          }
        } else {
          echo '<a>暫無留言，點擊</a>';
          echo '<a href="..\..\Frontend\BulletinBoardIndex.php">此處</a>';
          echo '<a>去首頁。</a>';
          exit;
        }

        // =============== 顯示留言區域 ===============
        ?>

      </div>
      <!-- 下方文章列表 區域 End -->

      <?php
      // 分頁或許另外寫一個獨立物件會比較好?
      // 目前的設計規劃是因為每一種分頁導覽列需要網址列參數不一定，所以必須分開來設置
      // 分頁邏輯區域start
      $totalPages = $pageData['totalPages'];
      $currentPage = $pageData['currentPage'];
      // 如果get有searchQuery那就執行包含searchQuery的分頁導覽列
      if (isset($_GET["searchQuery"])) {
        echo '<div class="pageNavArea">
            <nav aria-label="Page navigation">
              <ul class="pagination">
              <!-- 設定點擊後會跳轉的網址，拿到當前頁面後再減去1，並且確保page不會低於1 -->
                <li class="page-item"><a class="page-link" href="?searchQuery=' . $_GET["searchQuery"] . '&page=' . max(1, $currentPage - 1) . '">Previous</a></li>';
        for ($i = 1; $i <= $totalPages; $i++) {
          if ($currentPage - 3 < $i && $i < $currentPage + 3) {
            echo '<li class="page-item"><a class="page-link" href="?searchQuery=' . $_GET["searchQuery"] . '&page=' . $i . '">' . $i . '</a></li>';
          }
        }
        echo '<li class="page-item"><a class="page-link" href="?searchQuery=' . $_GET["searchQuery"] . '&page=' . min($totalPages, $currentPage + 1) . '">Next</a></li>
              </ul>
            </nav>
          </div>';
      } else {
        // 如果get有categoryId那就執行包含category的分頁導覽列
        if (isset($_GET["categoryId"])) {
          echo '<div class="pageNavArea">
              <nav aria-label="Page navigation">
                <ul class="pagination">
                  <li class="page-item"><a class="page-link" href="?categoryId=' . $_GET["categoryId"] . '&page=' . max(1, $currentPage - 1) . '">Previous</a></li>';
          for ($i = 1; $i <= $totalPages; $i++) {
            if ($currentPage - 3 < $i && $i < $currentPage + 3) {
              echo '<li class="page-item"><a class="page-link" href="?categoryId=' . $_GET["categoryId"] . '&page=' . $i . '">' . $i . '</a></li>';
            }
          }
          echo '<li class="page-item"><a class="page-link" href="?categoryId=' . $_GET["categoryId"] . '&page=' . min($totalPages, $currentPage + 1) . '">Next</a></li>
                </ul>
              </nav>
            </div>';
        } else {
          // 所有文章的分頁導覽列
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
        }
      }
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