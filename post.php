<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規投稿</title>
</head>
<body>
    <div style="text-align:center">
    <strong><font size="20">新規投稿</font></strong>
    </div>
    <a href="home.php">ホームへ戻る</a><br>
    <?php

    session_start();
    $user_name=$_SESSION['user_name'];
    $user_id=$_SESSION['user_id'];
    ?>
    <form action="thread.php" method="post">
        <label>
            タイトル
            <input type="text" name="post_name"><br>
        </label>
        <label>
            内容
            <textarea name="post_content" cols="30" rows="10" placeholder="ここに入力"></textarea><br>
        <input type="submit" value="投稿">
    </form>

</body>
</html>