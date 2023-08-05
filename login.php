<?php
session_start();
$user_name=htmlspecialchars($_POST['user_name'],ENT_QUOTES,'UTF-8');
$user_password=htmlspecialchars($_POST['user_password'],ENT_QUOTES,'UTF-8');
// $user_password=password_hash($temp,PASSWORD_DEFAULT);
// データベース名とホスト名を指定
$dsn='mysql:dbname=データベース名;host=localhost';
// ユーザ名
$user='ユーザ名';
// パスワード
$password='パスワード';
// array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)はデータベース操作でエラーが発生した場合に警告するためのオプション
// これがあることで不具合があった時に問題の発見が容易になる
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

// //テーブル作成
// $sql="CREATE TABLE IF NOT EXISTS user"
// ." ("
// . "id INT AUTO_INCREMENT PRIMARY KEY,"
// . "user_name char(10),"
// . "user_password char(255)"
// .");";
// $stmt = $pdo->query($sql);
// フォームに入力されたusernameが既に登録されていないかチェック
$sql="SELECT * FROM user WHERE user_name=:user_name";
$stmt=$pdo->prepare($sql);
$stmt->bindParam(':user_name', $user_name,PDO::PARAM_STR);
$stmt->execute();
$results=$stmt->fetch();
// echo $results['user_password'];
// ログインに成功したときの処理まだできてないのですること
if(password_verify($user_password, $results['user_password']))
{
    $_SESSION['user_id']=$results['user_id'];
    $_SESSION['user_name']=$results['user_name'];
    echo "ログインしました<br>";
    $hint=1;
    ?>
    <a href="home.php">ホームへ</a><br>
    <?php
}
else
{
    echo "ユーザ名またはパスワードが間違っています<br>";
    ?>
    <!-- 編集 -->
    <a href="login_form.php">戻る</a><br>
    <?php
}
?>