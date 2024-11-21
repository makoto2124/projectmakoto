<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $target_dir = "uploads/"; // アップロード先のディレクトリ
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // 画像ファイルか確認
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            echo "ファイルは画像です - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "ファイルは画像ではありません。";
            $uploadOk = 0;
        }
    }

    // ファイルが既に存在するか確認
    if (file_exists($target_file)) {
        echo "既に同じ名前のファイルが存在します。";
        $uploadOk = 0;
    }

    // ファイルサイズを制限
    if ($_FILES["image"]["size"] > 500000) {
        echo "ファイルが大きすぎます。";
        $uploadOk = 0;
    }

    // 許可されたファイル形式か確認
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "JPEG, PNG, JPG, GIF のみ許可されています。";
        $uploadOk = 0;
    }

    // エラーがなければアップロード
    if ($uploadOk == 0) {
        echo "ファイルはアップロードされませんでした。";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "ファイル ". htmlspecialchars(basename($_FILES["image"]["name"])) . " がアップロードされました。";
        } else {
            echo "アップロード中にエラーが発生しました。";
        }
    }
}
?>

<!-- アップロードされた画像を表示 -->
<?php
if (isset($target_file) && file_exists($target_file)) {
    echo "<h3>アップロードされた画像:</h3>";
    echo "<img src='" . $target_file . "' alt='Uploaded Image' style='max-width: 100%; height: auto;'>";
}
?>
