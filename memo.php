<?php
// 外部の設定ファイルからデータベース接続情報を読み込むなどの対策が必要です

session_start();

if (!isset($_SESSION['user_id'])) {
    // ログインしていない場合はログインページにリダイレクト
    header("Location: login.php");
    exit();
}

// データベースへの接続
$db_host = "localhost";
$db_user = "q6l";
$db_password = "";
$db_name = "SugoiMemo";
$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$connection) {
    die("データベースに接続できません: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['memoText']) && !empty($_POST['memoText'])) {

        $memoText = $_POST['memoText'];
        $characterCount = mb_strlen($memoText);
        $memoTitle = isset($_POST['memoTitle']) ? mysqli_real_escape_string($connection, $_POST['memoTitle']) : '';

        // ログインしているか確認
        if (isset($_SESSION['user_id'])) {
            // ユーザーID、メモタイトル、メモ本文、文字数をデータベースに保存
            $userId = $_SESSION['user_id'];
            $query = "INSERT INTO memos (user_id, memo_title, memo_text, character_count) VALUES ('$userId', '$memoTitle', '$memoText', '$characterCount')";
            $result = mysqli_query($connection, $query);
            if ($result) {
                echo "メモが保存されました";

                // .txt ファイルとしても保存
                $fileName = "memos/memo_" . $userId . "_" . time() . ".txt";
                file_put_contents($fileName, $memoText);
                echo "メモがテキストファイルとしても保存されました";
            } else {
                echo "メモの保存に失敗しました";
            }
        } else {
            echo "ログインしていません";
        }
    } else {
        echo "";
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
            <!-- メモの選択フォーム -->
            <form method="post" action="memo.php">
                <label for="memoTitleSelect">タイトルを選択：</label>
                <select id="memoTitleSelect" name="memoTitleSelect" onchange="loadMemo(this)">
                    <option value="">選択してください</option>
                    <?php
                    // ログインしているか確認
                    if (isset($_SESSION['user_id'])) {
                        // データベースへの接続
                        $db_host = "localhost";
                        $db_user = "q6l";
                        $db_password = "";
                        $db_name = "SugoiMemo";
                        $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

                        if ($connection) {
                            // ユーザーIDに基づいてメモのタイトルを取得
                            $userId = $_SESSION['user_id'];
                            $query = "SELECT memo_title FROM memos WHERE user_id = '$userId'";
                            $result = mysqli_query($connection, $query);

                            // 取得したメモのタイトルをドロップダウンに追加
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['memo_title'] . "'>" . $row['memo_title'] . "</option>";
                            }

                            mysqli_close($connection);
                        }
                    }
                    ?>
                </select>
                <button type="button" onclick="loadMemo(document.getElementById('memoTitleSelect'))">読み込む</button>
            </form>
        </div>
        <div>
            <!-- メモ入力フォーム -->
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
        <button onclick="saveMemo()">.txtとして保存</button>
        <button onclick="saveToDatabase()">データベースに保存</button>
        <button onclick="startRecognition()">音声入力を開始</button>
        <button onclick="resetRecognition()">音声入力を終了</button>
    </main>

    <footer>
        <p>&copy; 2023 スゴイメモ</p>
    </footer>
    <script src="script/memo.js"></script>
    <script src="script/script.js"></script>
</body>
</html>