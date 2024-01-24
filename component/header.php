<header>
        <h1>スゴイメモ +α</h1>
        <?php
        session_start();

        if (isset($_SESSION['user_name'])) {
            echo '<span class="login-status">' . $_SESSION['user_name'] . '</span>';
            echo '<a href="logout.php" class="login-link">ログアウト</a>';
        } else {
            echo '<a href="login.php" class="login-link">ログイン</a>';
        }
        ?>
    </header>