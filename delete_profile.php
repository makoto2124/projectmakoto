<?php
// データベース接続
try {
    $pdo = new PDO('mysql:host=localhost;dbname=project01', "root", "1234");
} catch(PDOException $e) {
    echo $e->getMessage();
}

// 削除ボタンが押されたとき
if (isset($_POST['delete'])) {
    $id = $_POST['id'];  // 削除対象のIDを取得

    try {
        // 削除クエリ
        $stmt = $pdo->prepare("DELETE FROM `project01-table` WHERE `id` = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);  // パラメータをバインド
        $stmt->execute();  // クエリを実行

        // 削除後、リダイレクトしてプロフィール一覧ページに戻る
        header("Location: index.php");
        exit();

    } catch (PDOException $e) {
        echo $e->getMessage();  // エラーハンドリング
    }
}

?>
