<!DOCTYPE html>
<html>
<head>
    <title>ログイン</title>
</head>
<body>
    <?php
    // データベース接続
    try {
        $conn = new PDO('mysql:dbname=mydb;host=localhost;charset=utf8','root','root');
    } catch (PDOException $e) {
        echo 'DB接続エラー！: ' . $e->getMessage();
    }
    // ログイン処理
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        // データベースからユーザー情報を取得
        $sql = "SELECT username, password FROM janken WHERE username = :username and password = :password";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // ユーザ名とパスワードが一致したらメイン画面へ、合致しなければエラーを表示
        if ($user) {
            session_start();
            $_SESSION['username'] = $username;
            header("Location: main.php");
        } else {
            echo "ログイン失敗。ユーザー名またはパスワードが違います。";
        }
    }
    ?>

    <h1>ログイン</h1>
    <form method="post">
        <label for="username">ユーザー名:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="ログイン">
        <a href='./register.php'>ユーザー登録はこちら</a>
    </form>
</body>
</html>
