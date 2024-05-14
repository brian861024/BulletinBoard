<?php
echo '
<div class="leftSectionArea">
<div class="navbarArea">
  <!-- 商品分類 -->
  <p class="w3-padding-large">
  <h5>留言分類</h5>
  </p>
  <hr class="dropdown-divider">

  <!-- 導覽列按鈕 分類 -->
'
?>

<?php
// 這邊必須用require_once，因為前面messageController有require
// require_once函數：require_once 表达式和 require 表达式完全相同，唯一区别是 PHP 会检查该文件是否已经被包含过，如果是则不会再次包含。
  require_once '/htdocs/Backend/Model/dao/categoryDaoPdo.php';
  $categoryDaoPdo = new categoryDaoPdo();
  $categories = $categoryDaoPdo->findAllCategories();
  if ($categories) {
    echo '
      <a class="classLink" href="http://localhost/Frontend/BulletinBoardIndex.php"> 所有留言 </a>
      <hr class="dropdown-divider">';
    foreach ($categories as $category) {
      echo '
      <a class="classLink" href="http://localhost/Frontend/BulletinBoardIndex.php?categoryId=' . $category->getId() . '">' . $category->getCategory() . '</a>
      <hr class="dropdown-divider">
      ';
    }
  }
?>

<?php
echo '
</div>
</div>
';
?>