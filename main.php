<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Mission</title>
</head>
<body>
    <h1>新規会員登録</h1>
    <form action="register.php" method="post">
        <div>
            <label>
                名前:
                <input type="text" name="user_name" placehoder="名前" required>
            </label>
        </div>
        <div>
            <label>
                パスワード:
                <input type="password" name="user_password" placehoder="パスワード" required>
            </label>
        </div>
        <input type="submit" value="新規登録">
    </form>
    
    <p><a href="login_form.php">ログイン</a></p>
    



</body>
</html>