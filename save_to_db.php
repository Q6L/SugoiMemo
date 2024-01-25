<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["memoText"])) {
    $memoText = $_POST["memoText"];

    // ログインしているか確認
    if (isset($_SESSION['user_id'])) {
        // データベースへの接続
        $db_host = "localhost";
        $db_user = "q6l";
        $db_password = "";
        $db_name = "SugoiMemo";
        $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

        if (!$connection) {
            die("データベースに接続できません: " . mysqli_connect_error());
        }

        // ユーザーIDとメモをデータベースに保存
        $userId = $_SESSION['user_id'];
        $query = "INSERT INTO memos (user_id, memo_text) VALUES ('$userId', '$memoText')";
        $result = mysqli_query($connection, $query);

        if ($result) {
            echo "メモがデータベースに保存されました";
        } else {
            echo "メモのデータベース保存に失敗しました";
        }

        // データベース接続のクローズ
        mysqli_close($connection);
    } else {
        echo "ログインしていません";
    }
} else {
    echo "不正なリクエストです";
}
?>
