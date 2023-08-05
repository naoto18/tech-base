<?php

session_start();
$user_name=$_SESSION['user_name'];
$user_id=$_SESSION['user_id'];
if(isset($_SESSION['user_id']))
{
    ?>
    <div style="text-align:center">
    <strong><font size="20">掲示板へようこそ</font></strong><br>
    </div>
    <div style="text-align:right">
    <a href="logout.php">ログアウト</a>
    </div>
    <br><br><br><br><br><br>
    <div style="text-align:right">
    <a href="post.php">新規スレッド</a>
    </div>
    <br><br>
    <?php
    //echo "こんにちは".$user_name."さん<br>";
    // データベース名とホスト名を指定
    $dsn='mysql:dbname=データベース名;host=localhost';
    // ユーザ名
    $user='ユーザ名';
    // パスワード
    $password='パスワード';
    // array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)はデータベース操作でエラーが発生した場合に警告するためのオプション
    // これがあることで不具合があった時に問題の発見が容易になる
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    echo "ようこそ".$user_name."さん<br>";
    $sql='SELECT * FROM post';
    $stmt=$pdo->query($sql);
    $results=$stmt->fetchAll();
    foreach($results as $row)
    {
        // echo $row['user_id'].'<br>';
        // echo $row['post_id'].'<br>';
        // echo $row['post_name'].'<br>';
        // echo $row['post_content'].'<br>';
        // echo "<hr>";
        ?>
        <a href="./article.php?post_id=<?php echo $row['post_id'];?>&user_id=<?php echo $user_id;?>"><?php echo $row['post_name'];?></a><br>
        <?php
    }
    
}
else
{
    echo "ログインしていません<br>";
    ?>
    <a href="login_form.php">ログイン</a>
    <?php

}

?>