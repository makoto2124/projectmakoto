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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Image Example</title>
</head>
<body>
    <h1>プロフィール一覧</h1>
    

<body>
    <h2>
    <a href="edit_profile.php">新しいプロフィールを追加</a>
    </h2>
    <div class="profile-container">
        
    </div>
    <?php foreach($comment_array as $comment): ?>
    <div class="howUse">
        <div class="container">
            <div class="how-use-wrapper">
                <div class="howUse-card">         <!--一つのカードの大枠-->
                    <div class="how-use-inner">
                       <img class="howUse-image" src= "IMG_0491.JPG"$_COOKIE alt="プロフィール写真">
                        <h3 class="howUse-title"><?php echo $comment["name"];?></h3>
                        <p class="howUse-text"><?php echo $comment["age"];?></p>
                        <p class="howUse-text"><?php echo $comment["profile"];?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php endforeach; ?>

</body>

</html>

