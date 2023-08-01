<!DOCTYPE html>
<html>
<head>
    <title>じゃんけんゲーム</title>
</head>
<body>
    <h1>じゃんけんゲーム</h1>
    <p>じゃんけんの手を選択して、選択ボタンをクリックすると、コンピューターをジャンケンができます！</p>
    <form method="post" action="play.php">
        <label>
            <img src="/img/janken_gu.png" width=50>
            <img src="/img/janken_choki.png" width=50>
            <img src="/img/janken_pa.png" width=50>
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
</body>
</html>
