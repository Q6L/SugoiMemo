<!-- memo_detail.php -->

<?php
// メモIDをクエリ文字列から取得
if (isset($_GET['id'])) {
    $memoId = $_GET['id'];

    // メモの詳細データを取得するクエリ（例）
    // この部分は実際のデータベースクエリに置き換える必要があります
    $memoDetail = array(
        'id' => $memoId,
        'title' => 'メモ' . $memoId,
        'content' => 'メモ' . $memoId . 'の内容。',
        // 他のメモの詳細データ
    );

    // メモの詳細を表示
    echo '<h1>' . $memoDetail['title'] . '</h1>';
    echo '<p>' . $memoDetail['content'] . '</p>';
} else {
    echo 'メモIDが指定されていません。';
}
?>
