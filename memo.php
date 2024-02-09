<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['selectedTitle']) && !empty($_POST['selectedTitle'])) {
        $userId = $_SESSION['user_id'];
        $selectedTitle = $_POST['selectedTitle'];

        $db_host = "localhost";
        $db_user = "q6l";
        $db_password = "";
        $db_name = "SugoiMemo";
        $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

        if ($connection) {
            $query = "SELECT memo_text FROM memos WHERE user_id = '$userId' AND memo_title = '$selectedTitle'";
            $result = mysqli_query($connection, $query);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                echo $row['memo_text'];
            } else {
                echo "メモの読み込みに失敗しました: " . mysqli_error($connection);
            }

            mysqli_close($connection);
        } else {
            echo "データベースに接続できません: " . mysqli_connect_error();
        }
    } else {
        echo "選択されたタイトルがありません";
    }
} else {
    echo "";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メモアプリ</title>
    <link rel="stylesheet" href="css/memo.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/n_timer.css">
    <style>
        .line {
            border-top: 1px solid #ccc;
            margin-top: 10px;
        }

        .interim {
            color: gray;
            font-style: italic;
        }
    </style>
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
        <div>
            <form method="post" action="memo.php">
                <label for="memoTitleSelect">タイトルを選択：</label>
                <select id="memoTitleSelect" name="memoTitleSelect" onchange="loadMemo(this)">
                    <option value="">選択してください</option>
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        $db_host = "localhost";
                        $db_user = "q6l";
                        $db_password = "";
                        $db_name = "SugoiMemo";
                        $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

                        if ($connection) {
                            $userId = $_SESSION['user_id'];
                            $query = "SELECT memo_title FROM memos WHERE user_id = '$userId'";
                            $result = mysqli_query($connection, $query);

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['memo_title'] . "'>" . $row['memo_title'] . "</option>";
                            }

                            mysqli_close($connection);
                        }
                    }
                    ?>
                </select>
            </form>
        </div>
        <div>
            <form method="post" action="memo.php">
                <label for="memoTitle">タイトル：</label>
                <input type="text" id="memoTitle" name="memoTitle" placeholder="メモのタイトル">
            </form>
        </div>
        <div>
            <textarea id="memoInput" name="memoText" placeholder="メモを入力してください" oninput="countCharacters(this)"></textarea>
            <div class="line"></div>
            <p id="characterCount">0文字</p>
        </div>
        <button onclick="startRecognition()">音声入力を開始</button>
        <button onclick="resetRecognition()">音声入力を終了</button>
        <button onclick="saveMemo()">.txtとして保存</button>
        <button onclick="saveToDatabase()">データベースに保存</button>
        <button onclick="deleteMemo()">データベースから削除</button>
    </main>

    <footer>
        <p>&copy; 2023 スゴイメモ</p>
    </footer>
    <script src="script/memo.js"></script>
    <script src="script/script.js"></script>
</body>
</html>