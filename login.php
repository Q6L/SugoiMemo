<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
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
            <form class="login-form">
                <input type="text" placeholder="ID"/>
                <input type="password" placeholder="パスワード"/>
                <button>ログイン</button>
                <p class="message">未登録ですか？ <a href="register.html">アカウントを作成</a></p>
            </form>
        </div>
    </div>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> メモアプリ</p>
    </footer>
    <script src="script/login.js"></script>
    <script src="script/script.js"></script>
</body>
</html>