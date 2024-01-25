<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['memoText']) && !empty($_POST['memoText'])) {
        $memoText = $_POST['memoText'];
        $characterCount = mb_strlen($memoText);
        $memoTitle = isset($_POST['memoTitle']) ? $_POST['memoTitle'] : 'Untitled';

        // ログインしているか確認
        if (isset($_SESSION['user_id'])) {
            // データベースへの接続
            $db_host = "localhost";
            $db_user = "memo";
            $db_password = "";
            $db_name = "memo";
            $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

            if (!$connection) {
                die("データベースに接続できません: " . mysqli_connect_error());
            }

            // ユーザーID取得
            $userId = $_SESSION['user_id'];

            // 既存のメモを取得するか確認
            if (isset($_POST['memoTitleSelect']) && !empty($_POST['memoTitleSelect'])) {
                $selectedTitle = $_POST['memoTitleSelect'];

                // 既存のメモを上書き
                $query = "UPDATE memos SET memo_text = ?, character_count = ? WHERE user_id = ? AND memo_title = ?";
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($stmt, "sisi", $memoText, $characterCount, $userId, $selectedTitle);

                if (mysqli_stmt_execute($stmt)) {
                    echo "メモが更新されました";
                } else {
                    echo "メモの更新に失敗しました: " . mysqli_error($connection);
                }
            } else {
                // 新しいメモを追加
                $query = "INSERT INTO memos (user_id, memo_text, character_count, memo_title) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($stmt, "issi", $userId, $memoText, $characterCount, $memoTitle);

                if (mysqli_stmt_execute($stmt)) {
                    echo "メモが保存されました";
                } else {
                    echo "メモの保存に失敗しました: " . mysqli_error($connection);
                }
            }

            mysqli_close($connection);
        } else {
            echo "ログインしていません";
        }
    } else {
        echo "メモが空です";
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
            <!-- メモ読み込みフォーム -->
            <form id="loadMemoForm">
                <label for="memoTitleSelect">タイトルを選択：</label>
                <select id="memoTitleSelect" name="memoTitleSelect">
                    <?php
                    // ログインしているか確認
                    if (isset($_SESSION['user_id'])) {
                        // データベースへの接続
                        $db_host = "localhost";
                        $db_user = "memo";
                        $db_password = "";
                        $db_name = "memo";
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
                <button type="button" onclick="loadMemo()">読み込む</button>
            </form>
        </div>
        <div>
            <!-- メモ入力フォーム -->
            <form id="saveMemoForm">
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

    <script>

    </script>
    <script src="script/memo.js"></script>
</body>
</html>
