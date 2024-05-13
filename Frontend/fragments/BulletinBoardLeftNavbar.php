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