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
        $memoText = mysqli_real_escape_string($connection, $_POST['memoText']);

        $checkQuery = "SELECT COUNT(*) FROM memos WHERE user_id = '$userId' AND memo_title = '$memoTitle'";
        $checkResult = mysqli_query($connection, $checkQuery);
        $count = mysqli_fetch_assoc($checkResult)['COUNT(*)'];

        if ($count > 0) {
            echo "TitleDuplicateError";
        } else {
            $insertQuery = "INSERT INTO memos (user_id, memo_title, memo_text) VALUES ('$userId', '$memoTitle', '$memoText')";
            $insertResult = mysqli_query($connection, $insertQuery);

            if ($insertResult) {
                echo "Success";
            } else {
                echo "Error";
            }
        }

        mysqli_close($connection);
    }
}
?>