<?php
if (isset($_GET['id'])) {
    $memoId = $_GET['id'];

    $memoDetail = array(
        'id' => $memoId,
        'title' => 'メモ' . $memoId,
        'content' => 'メモ' . $memoId . 'の内容。',
    );

    echo '<h1>' . $memoDetail['title'] . '</h1>';
    echo '<p>' . $memoDetail['content'] . '</p>';
} else {
    echo 'メモIDが指定されていません。';
}
?>
