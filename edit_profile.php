<?php

$comment_array = array();

try{
    $pdo = new PDO('mysql:host=localhost;dbname=project01', "root", "1234");
}catch(PDOException $e){
    echo $e->getMessage();
}

if(!empty($_POST["submit"])){
    try{
        $stmt = $pdo->prepare("INSERT INTO `project01-table` (`name`, `age`, `profile`) VALUES (:name, :age, :profile);");
        $stmt->bindParam(':name', $_POST['name'],PDO::PARAM_STR);
        $stmt->bindParam(':age', $_POST['age'],PDO::PARAM_STR);
        $stmt->bindParam(':profile', $_POST['profile'],PDO::PARAM_STR);
        $stmt->execute();

    
    }catch(PDOException $e){
        echo $e->getMessage();
    }
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
    <title>プロフィール編集</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
   

    <h1 class="prof">新しいプロフィールを追加</h1>
    <form class="register" method="POST">
        <h2>名前: <input type="text" name="name" value=""></h2>
        <h2>年齢: <input type="text" name="age" value=""></h2>
        <h2>自己紹介: <textarea name="profile"></textarea></h2>
        <h2>プロフィール画像: <input type="file" name="image" accept="image/*"></h2>
        <h2><input type="submit" name="submit" value="保存" ></h2>
    </form>
    <hr>

    
    

    <body>
    <h2>
    <a href="index.php">プロフィール一覧</a>
    </h2>
    <div class="profile-container">
        
    </div>
    </body>

    
</body>
</html>
