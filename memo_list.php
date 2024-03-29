<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db_host = "localhost";
$db_user = "q6l";
$db_password = "";
$db_name = "SugoiMemo";
$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$connection) {
    die("データベースに接続できません: " . mysqli_connect_error());
}

$userId = $_SESSION['user_id'];

$query = "SELECT * FROM memos WHERE user_id = '$userId'";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("クエリの実行に失敗しました: " . mysqli_error($connection));
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/n_timer.css">
    <title>Home</title>
    <title>メモ一覧</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include './component/header.php'; ?>
    <div id="navArea">
        <?php include './component/nav.php'; ?>
        <div class="toggle-btn">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div id="mask"></div>
    </div>

    <main>
        <h2>メモ一覧</h2>
        <ul>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>";
                echo "<strong>" . htmlspecialchars($row['memo_title']) . "</strong><br>";
                echo htmlspecialchars($row['memo_text']);
                echo "</li>";
            }
            ?>
        </ul>
    </main>

    <footer>
        <p>&copy; 2023 スゴイメモ</p>
    </footer>

    <?php
    mysqli_free_result($result);
    mysqli_close($connection);
    ?>
</body>
<script src="script/script.js"></script>
</html>
