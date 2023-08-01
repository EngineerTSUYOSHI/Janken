<!DOCTYPE html>
<html>
<head>
    <title>じゃんけんゲーム</title>
</head>
<body>
    <?php
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // コンピュータの手をランダムに取り出し
        $randomNumber = rand(0, 2);
        $computerHand = getHand($randomNumber);
        $computerHandImg = getHandImg($randomNumber);
        
        $playerHand = getHand($_POST['player_hand']);
        $playerHandImg = getHandImg($_POST['player_hand']);
        
        $result = getResult($playerHand, $computerHand);

        echo "<h1>じゃんけんゲーム</h1>";
        echo "<p>あなたの手: " . $playerHand . "</p>";
        echo "<img src='/img/$playerHandImg' width=50>";
        echo "<p>相手の手: " . $computerHand . "</p>";
        echo "<img src='/img/$computerHandImg' width=50>";
        echo "<h2>結果はあなたの$result";
    } else {
        echo "<h2>結果: " . $result . "</h2>";
        header("Location: index.php");
        exit;
    }
    ?>
    <p><a href="index.php">もう一回遊ぶ</a></p>
</body>
</html>
