<?php
// 此Dao用於管理分類之新增、刪除、修改的資料庫連線

require_once '/htdocs/Backend/Model/bean/category.php';

class categoryDaoPdo
{
    //===========================================================================
    //新增分類 區域 start

    //新增分類 區域 end
    //===========================================================================
    //刪除分類 區域 start

    //刪除分類 區域 end
    //===========================================================================
    //修改分類 區域 start

    //修改分類 區域 end
    //===========================================================================
    //查詢分類 區域 start
    // 1.透過id查找分類
    public function findCategoryById($id)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "SELECT category FROM category WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
        $categoryData = $stmt->fetch(PDO::FETCH_ASSOC);
        $category = $categoryData['category'];
        return $category;
    }

    // 2.找出所有分類
    // 此功能會建立目前分類總數的建構子，總數會在category類裡面自動計算
    public function findAllCategories()
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "SELECT id, category FROM category;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([]);
        // 將回傳之$stmt物件透過fetchAll()函數拆開
        $categoryDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categorys = [];
        foreach ($categoryDataArray as $categoryData) {
            // 把拆開的陣列裝入category物件並回傳
            $category = new category();
            $category->setId($categoryData['id']);
            $category->setCategory($categoryData['category']);
            $categorys[] = $category;
        }
        return $categorys;
    }

    // 3.計算出目前分類總數
    // 此功能找出所有分類，計算後回傳總數
    public function countAllCategories()
    {
        $pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "1111");
        $sql = "SELECT id, category FROM category;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([]);
        // 將回傳之$stmt物件透過fetchAll()函數拆開
        $categoryDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categorySum = 0;
        foreach ($categoryDataArray as $categoryData) {
            $categorySum++;
        }
        return $categorySum;
    }

    //查詢分類 區域 end
}
