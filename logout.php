<?php
session_start();

// セッションを破棄してログアウト
session_destroy();

// ログアウト後にリダイレクト
header("Location: index.php");
exit();
?>
