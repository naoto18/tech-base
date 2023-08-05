<?php
define("MAX_user_name",17);

$user_name=htmlspecialchars($_POST['user_name'],ENT_QUOTES,'UTF-8');
$temp=htmlspecialchars($_POST['user_password'],ENT_QUOTES,'UTF-8');
$user_password=password_hash($temp,PASSWORD_DEFAULT);
// データベース名とホスト名を指定
$dsn='mysql:dbname=データベース名;host=localhost';
// ユーザ名
$user='ユーザ名';
// パスワード
$password='パスワード';
// array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)はデータベース操作でエラーが発生した場合に警告するためのオプション
// これがあることで不具合があった時に問題の発見が容易になる
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));



// フォームに入力されたusernameが既に登録されていないかチェック
// if(strlen($user_name)<MAX_user_name)
// {
    $sql="SELECT * FROM user WHERE user_name=:user_name";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':user_name', $user_name,PDO::PARAM_STR);
    $stmt->execute();
    $results=$stmt->fetch();
    if($results['user_name']===$user_name)
    {
        echo "同じユーザ名またはパスワードが存在します<br>";
        ?>
        <a href="main.php">戻る</a><br>
        <?php

    }
    else
    {
        // 挿入
        $sql=$pdo->prepare("INSERT INTO user(user_name, user_password) values(:user_name, :user_password)");
        $sql->bindParam(':user_name', $user_name,PDO::PARAM_STR);
        $sql->bindParam(':user_password',$user_password, PDO::PARAM_STR);
        $sql->execute();
        ?>
        <a href="main.php">戻る</a><br>
        <?php

    }

?>