<?php

session_start();
if (isset($_GET['post_id'])&&isset($_GET['user_id'])) {
  $user_id=$_GET['user_id'];
  $post_id = $_GET['post_id'];
//   echo $user_id;
//   echo $post_id;
}
// (3) SQL作成
// データベース名とホスト名を指定
$dsn='mysql:dbname=データベース名;host=localhost';
// ユーザ名
$user='ユーザ名';
// パスワード
$password='パスワード';
// array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)はデータベース操作でエラーが発生した場合に警告するためのオプション
// これがあることで不具合があった時に問題の発見が容易になる
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>
<!DOCTYPE html>
<html lang="ja">
<head>
</head>
<body>
  <?php
$sql='SELECT * FROM post WHERE post_id=:post_id';
$stmt=$pdo->prepare($sql);
$stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
$stmt->execute();
    // 差し替えるパラメータを含めて記述したSQL文を準備
    // その差しけるパラメータの値を指定してから
    // SQL文を実行する
$results=$stmt->fetchAll();
foreach($results as $row)
    { ?>
        <div style="text-align:center">
        <strong><font size="20">
        <?php
        // echo $row['user_id'].'<br>';
        echo $row['post_name'].'<br>';
        ?>
        </font></strong>
        <?php
        echo $row['post_content'].'<br>';
        echo "<hr>";
        ?>
        </div>
        <div style="text-align:left">
        <a href="home.php">ホームへ戻る</a><br>
        </div>
        <?php
    }

    if(!empty($_POST['comment_content']))
    {
    $comment_content=htmlspecialchars($_POST["comment_content"],ENT_QUOTES,'UTF-8');
    $sql=$pdo->prepare("INSERT INTO comment(user_id,post_id,comment_content) values(:user_id,:post_id,:comment_content)");
    $sql->bindParam(':user_id',$user_id,PDO::PARAM_INT);
    $sql->bindParam(':post_id',$post_id,PDO::PARAM_INT);
    $sql->bindParam(':comment_content',$comment_content,PDO::PARAM_STR);
    $sql->execute();
    }
    
    $sql='SELECT user.user_name, comment.comment_content,comment.created_at FROM user,comment WHERE comment.user_id=user.user_id and post_id=:post_id';
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':post_id',$post_id,PDO::PARAM_INT);
    $stmt->execute();
    $results=$stmt->fetchAll();
    foreach($results as $row)
    {
        echo $row['user_name']."<br>";
        echo $row['comment_content']."<br>";
        echo $row['created_at']."<br>";
        echo "<hr>";
    }

    ?>

    <form action="" method="post">
        <label>
    コメント<br><textarea name="comment_content" cols="30" rows="10" placeholder="ここに入力"></textarea><br>
    </label>
    <input type="submit" value="投稿"><br>
</body>
</html>