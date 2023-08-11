<!DOCTYPE html>
<html>
<head>
    <title>じゃんけんゲーム</title>
</head>
<body>
    <?php
    // メイン処理
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $conn = new PDO('mysql:dbname=mydb;host=localhost;charset=utf8','root','root');
        } catch (PDOException $e) {
            echo 'DB接続エラー！: ' . $e->getMessage();
        }
        // コンピュータの手をランダムに取り出し
        session_start();
        $username = $_SESSION['username'];

        $randomNumber = rand(0, 2);
        $computerHand = getHand($randomNumber);
        $computerHandImg = getHandImg($randomNumber);
        
        $playerHand = getHand($_POST['player_hand']);
        $playerHandImg = getHandImg($_POST['player_hand']);
        
        $result = getResult($playerHand, $computerHand);
        
        // データベースに結果を登録
        $sql = "INSERT INTO result (username, result) VALUES (:username, :result)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':result', $result);
        $stmt->execute();
        // データベースから成績を取得
        $sql = "SELECT SUM(result = '勝ち') AS wins, SUM(result = '負け') AS losses, SUM(result = '引き分け') AS draws FROM result WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: index.php");
        exit;
    }

    // 引数numberから選択した手を返す
    function getHand($number) {
        $hands = ['グー', 'チョキ', 'パー'];
        return $hands[$number];
    }

    // 引数numberから選択した手のイメージファイル名を返す
    function getHandImg($number){
        $handsImg = ['janken_gu.png', 'janken_choki.png', 'janken_pa.png'];
        return $handsImg[$number];
    }

    // 結果を判定
    function getResult($player, $computer) {
        if ($player === $computer) {
            return '引き分け';
        } elseif (
            ($player === 'グー' && $computer === 'チョキ') ||
            ($player === 'チョキ' && $computer === 'パー') ||
            ($player === 'パー' && $computer === 'グー')
        ) {
            return '勝ち';
        } else {
            return '負け';
        }
    }
    ?>
    
    <h1>じゃんけんゲーム</h1>
    <p><?php echo $username ?>の手は<?php echo $playerHand ?></p>
    <img src='./img/<?php echo $playerHandImg ?>' width=50>
    <p>相手の手: <?php echo $computerHand ?></p>
    <img src='./img/<?php echo $computerHandImg ?>' width=50>
    <h2>結果はあなたの<?php echo $result ?></h2>

    <p><a href="main.php">もう一回遊ぶ</a></p>
    
    <h2>成績</h2>
    <table border="1">
    <tr>
        <th>勝ち</th>
        <th>負け</th>
        <th>引き分け</th>
    </tr>
    <tr>
        <td><?php echo $row['wins']; ?>回</td>
        <td><?php echo $row['losses']; ?>回</td>
        <td><?php echo $row['draws']; ?>回</td>
    </tr>
    </table>
</body>
</html>