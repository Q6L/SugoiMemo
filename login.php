<?php
$db_host = "localhost";
$db_user = "q6l";
$db_password = "";
$db_name = "memo";

$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$connection) {
    die("データベースに接続できません: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $hashedPassword = $row["password"];

            if (password_verify($password, $hashedPassword)) {
                header("Location: index.html");
                exit();
            } else {
                echo "無効なパスワードです。";
            }
        } else {
            echo "無効なメールアドレスです。";
        }
    } else {
        echo "クエリの実行に失敗しました: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/n_timer.css">
    <title>ログイン</title>
</head>
<body>
    <header>
        <h1>スゴイメモ +α</h1>
    </header>
    <div id="navArea">
        <nav>
            <div class="inner">
                <ul>
                    <li class="border"></li>
                    <li><a href="index.html">ホーム</a></li>
                    <li><a href="memo.html">スゴイメモ</a></li>
                    <li><a href="n_timer.html">n進数タイマー</a></li>
                </ul>
            </div>
        </nav>

        <div class="toggle-btn">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div id="mask"></div>
    </div>
    <div class="login-page">
        <div class="form">
            <form class="login-form" method="post" action="login.php">
                <input type="text" name="email" placeholder="メールアドレス" required/>
                <input type="password" name="password" placeholder="パスワード" required/>
                <button type="submit">ログイン</button>
                <p class="message">未登録ですか？ <a href="register.php">アカウントを作成</a></p>
            </form>
        </div>
    </div>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> スゴイメモ</p>
    </footer>
    <script src="script/script.js"></script>
</body>
</html>