<?php

session_start();
$_SESSION=array();
session_destroy();
?>

<p>ログアウトしました</p>
<a href="login_form.php">ログイン画面へ</a>