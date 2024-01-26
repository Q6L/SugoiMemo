<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $db_host = "localhost";
    $db_user = "q6l";
    $db_password = "";
    $db_name = "SugoiMemo";
    $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

    if ($connection) {
        $userId = $_SESSION['user_id'];
        $memoTitle = mysqli_real_escape_string($connection, $_POST['memoTitle']);
        $query = "DELETE FROM memos WHERE user_id = '$userId' AND memo_title = '$memoTitle'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            echo "メモが削除されました";
        } else {
            echo "メモの削除に失敗しました";
        }

        mysqli_close($connection);
    }
}
?>
