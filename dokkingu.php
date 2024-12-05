<?php

$comment_array = array();

try{
    $pdo = new PDO('mysql:host=localhost;dbname=project01', "root", "1234");
}catch(PDOException $e){
    echo $e->getMessage();
}



$sql = "SELECT * FROM `project01-table`;";
$comment_array = $pdo->query($sql);



//DBの接続を閉じる
$pdo = null;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dokkingu.css">
    <title>マッチング機能</title>
</head>
<body>
    <a href="index.php">プロフィール一覧へ</a>   
    <h1>マッチング機能</h1>
    <form method="POST" action="">
        <label for="gender">性別：</label>
        <select name="gender" id="gender">
            <option value="男性">男性</option>
            <option value="女性">女性</option>
        </select>
        
        <label for="age_min">年齢（最小）：</label>
        <input type="number" name="age_min" id="age_min" min="18" required>
        
        <label for="age_max">年齢（最大）：</label>
        <input type="number" name="age_max" id="age_max" min="18" required>
        
        <button type="submit" name="match">マッチング開始</button>
    </form>
    
    <h2>マッチング結果</h2>
    <div class="match-results">
        <?php
        // データベース接続情報
        $dsn = 'mysql:host=localhost;dbname=project01;charset=utf8';
        $username = 'root';
        $password = '1234';

        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $gender = $_POST['gender'];
                $age_min = $_POST['age_min'];
                $age_max = $_POST['age_max'];

                // マッチング条件に合うプロフィールを取得
                $stmt = $pdo->prepare("SELECT * FROM `project01-table` WHERE gender = :gender AND age BETWEEN :age_min AND :age_max");
                $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
                $stmt->bindParam(':age_min', $age_min, PDO::PARAM_INT);
                $stmt->bindParam(':age_max', $age_max, PDO::PARAM_INT);
                $stmt->execute();

                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($results) > 0) {
                    foreach ($results as $comment) {
                        echo "<div class='profile-card'>";
                        echo "<img src='data:image/*;base64," . base64_encode($comment['image']) . "' alt='プロフィール写真' class='profile-image'>";
                        echo "<h3>" . htmlspecialchars($comment['name'], ENT_QUOTES, 'UTF-8') . "</h3>";
                        echo "<p>性別: " . htmlspecialchars($comment['gender'], ENT_QUOTES, 'UTF-8') . "</p>";
                        echo "<p>年齢: " . htmlspecialchars($comment['age'], ENT_QUOTES, 'UTF-8') . "</p>";
                        echo "<p>プロフィール: " . htmlspecialchars($comment['profile'], ENT_QUOTES, 'UTF-8') . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>マッチするプロフィールが見つかりませんでした。</p>";
                }
            }
        } catch (PDOException $e) {
            echo "<p>エラー: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>
</body>
</html>
