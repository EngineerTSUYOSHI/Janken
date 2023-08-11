<!DOCTYPE html>
<html>
<head>
    <title>じゃんけんゲーム</title>
</head>
<body>
    <?php
    session_start();
    if (isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        echo "ようこそ、{$username} さん！";
    }else{
        header("Location: index.php");
        exit;
    }
    // ログアウトボタンを押した時の処理
    if (isset($_POST['logout'])) {
        // セッションを破棄してログイン画面へ遷移
        session_destroy();
        header("Location: index.php");
        exit;
    }
    ?>

    <h1>じゃんけんゲーム</h1>
    <p>じゃんけんの手を選択して、選択ボタンをクリックすると、コンピューターをジャンケンができます！</p>
    <form method="post" action="play.php">
        <label>
            <img src="./img/janken_gu.png" width=50>
            <img src="./img/janken_choki.png" width=50>
            <img src="./img/janken_pa.png" width=50>
        </label>
        <br>
        <label>
            <input type="radio" name="player_hand" value="0" required>グー
            <input type="radio" name="player_hand" value="1">チョキ
            <input type="radio" name="player_hand" value="2">パー
        </label>
        <br>
        <input type="submit" value="じゃんけんする">
    </form>

    <form method="post">
        <input type="submit" name="logout" value="ログアウト">
    </form>
</body>
</html>