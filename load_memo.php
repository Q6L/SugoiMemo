<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['selectedTitle']) && !empty($_POST['selectedTitle'])) {
        $userId = $_SESSION['user_id'];
        $selectedTitle = $_POST['selectedTitle'];

        $db_host = "localhost";
        $db_user = "q6l";
        $db_password = "";
        $db_name = "SugoiMemo";
        $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

        if ($connection) {
            $query = "SELECT memo_text FROM memos WHERE user_id = '$userId' AND memo_title = '$selectedTitle'";
            $result = mysqli_query($connection, $query);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                echo $row['memo_text'];
            } else {
                echo "メモの読み込みに失敗しました";
            }

            mysqli_close($connection);
        } else {
            echo "データベースに接続できません";
        }
    } else {
        echo "選択されたタイトルがありません";
    }
} else {
    echo "無効なリクエスト";
}
?>