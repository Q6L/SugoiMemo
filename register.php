<?php
$db_host = "localhost";
$db_user = "q6l";
$db_password = ""; // 本番環境では適切なパスワードを設定してください
$db_name = "memo";

$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$connection) {
    die("データベースに接続できません: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $password = $_POST["password"];
    $email = $_POST["email"];

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
            $insertQuery = "INSERT INTO users (id, name, password, email) VALUES ('$id', '$name', '$hashedPassword', '$email')";
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
            <form class="register-form" method="post" action="register.php">
                <input type="text" name="id" placeholder="ID" required/>
                <input type="text" name="name" placeholder="名前" required/>
                <input type="password" name="password" placeholder="パスワード" required/>
                <input type="text" name="email" placeholder="メールアドレス" required/>
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
