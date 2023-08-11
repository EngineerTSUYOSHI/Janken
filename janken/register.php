<!DOCTYPE html>
<html>
<head>
    <title>ユーザー登録</title>
</head>
<body>
    <?php
    // データベース接続
    try {
        $conn = new PDO('mysql:dbname=mydb;host=localhost;charset=utf8','root','root');
    } catch (PDOException $e) {
        echo 'DB接続エラー！: ' . $e->getMessage();
    }
    // フォームが送信された場合の処理
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        // データベースにユーザーを追加するクエリ
        $sql = "INSERT INTO janken (username, password) VALUES ('$username', '$password')";
        try{
            $conn->query($sql);
            echo "ユーザーが登録されました";
        }catch (PDOException $e){
            // ユーザ名はユニーク制約有り。同一名の重複は不可
            if ($e->getCode() == 23000 && $e->errorInfo[1] == 1062) {
                echo "そのユーザ名はすでに使用されています。別の名前を使用してください。";
            } else {
                echo "エラー: " . $e->getMessage();
            }
        }
    }
    ?>

    <h1>ユーザー登録</h1>
    <form method="post">
        <label for="username">ユーザー名:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="登録">
        <a href='./index.php'>ログイン画面へ戻る</a>
    </form>
</body>
</html>