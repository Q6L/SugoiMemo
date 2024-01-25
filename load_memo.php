<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['selectedTitle']) && !empty($_POST['selectedTitle'])) {
        // ユーザーIDと選択されたタイトルを使用してデータベースからメモを取得
        $userId = $_SESSION['user_id'];
        $selectedTitle = $_POST['selectedTitle'];

        // データベースへの接続
        $db_host = "localhost";
        $db_user = "memo";
        $db_password = "";
        $db_name = "memo";
        $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

        if ($connection) {
            $query = "SELECT memo_title, memo_text FROM memos WHERE user_id = '$userId' AND memo_title = '$selectedTitle'";
            $result = mysqli_query($connection, $query);

            if ($result) {
                $row = mysqli_fetch_assoc($result);

                // メモデータをJSON形式で返す
                echo json_encode($row);
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
