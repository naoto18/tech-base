<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>チャンネル作成</title>
</head>
<body>
    <?php
    define("MAX_post_name",65);

    session_start();
    $user_name=$_SESSION['user_name'];
    $user_id=$_SESSION['user_id'];
    // $user_name=$_SESSION['user_name'];
    $post_name=htmlspecialchars($_POST['post_name'],ENT_QUOTES,'UTF-8');
    $post_content=htmlspecialchars($_POST['post_content'],ENT_QUOTES,'UTF-8');
    // $thread_comment=htmlspecialchars($_POST['thread_comment'],ENT_QUOTES,'UTF-8');

    // データベース名とホスト名を指定
    $dsn='mysql:dbname=データベース名;host=localhost';
    // ユーザ名
    $user='ユーザ名';
    // パスワード
    $password='パスワード';
    // array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)はデータベース操作でエラーが発生した場合に警告するためのオプション
    // これがあることで不具合があった時に問題の発見が容易になる
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    $sql=$pdo->prepare("INSERT INTO post(user_id,post_name,post_content) values(:user_id, :post_name, :post_content)");
    $sql->bindParam('user_id',$user_id,PDO::PARAM_INT);
    $sql->bindParam('post_name',$post_name,PDO::PARAM_STR);
    $sql->bindParam('post_content',$post_content,PDO::PARAM_STR);
    $sql->execute();

    ?>
    <a href="home.php">戻る</a><br>
    <?php








    ?>
</body>
</html>