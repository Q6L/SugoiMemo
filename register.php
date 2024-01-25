<?php
session_start();

// データベースへの接続
$db_host = "localhost";
$db_user = "memo";
$db_password = ""; 
$db_name = "memo";
$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$connection) {
    die("データベースに接続できません: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = mysqli_real_escape_string($connection, $_POST["name"]);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);
    $email = mysqli_real_escape_string($connection, $_POST["email"]);

    // パスワードをハッシュ化
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // ユーザの重複を確認
    $checkQuery = "SELECT * FROM users WHERE email='$email'";
    $checkResult = mysqli_query($connection, $checkQuery);

    if ($checkResult) {
        if (mysqli_num_rows($checkResult) > 0) {
            echo "このメールアドレスは既に使用されています。";
        } else {
            // ユーザをデータベースに挿入
            $insertQuery = "INSERT INTO users (user_name, password, email) VALUES ('$userName', '$hashedPassword', '$email')";
            $insertResult = mysqli_query($connection, $insertQuery);

            if ($insertResult) {
                echo "アカウントが作成されました。 <a href='login.php'>ログイン</a>";
            } else {
                echo "アカウントの作成に失敗しました: " . mysqli_error($connection);
            }
        }
    } else {
        echo "クエリの実行に失敗しました: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/n_timer.css">
    <title>アカウント作成</title>
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
                    <li><a href="index.php">ホーム</a></li>
                    <li><a href="memo.php">スゴイメモ</a></li>
                    <li><a href="n_timer.php">n進数タイマー</a></li>
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
            <form class="register-form" method="post" action="register.php">
                <input type="text" name="name" placeholder="名前" required/>
                <input type="text" name="email" placeholder="メールアドレス" required/>
                <input type="password" name="password" placeholder="パスワード" required/>
                <button type="submit">作成</button>
                <p class="message">登録済みですか？ <a href="login.php">サインイン</a></p>
            </form>
        </div>
    </div>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> スゴイメモ</p>
    </footer>
    <script src="script/script.js"></script>
</body>
</html>
