<?php
session_start();

$db_host = "localhost";
$db_user = "q6l";
$db_password = ""; 
$db_name = "SugoiMemo";
$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$connection) {
    die("データベースに接続できません: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($connection, $_POST["email"]);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            header("Location: index.php");
            exit();
        } else {
            echo "パスワードが正しくありません。";
        }
    } else {
        echo "メールアドレスが見つかりません。";
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
    <?php include './component/nav.php'; ?>
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
