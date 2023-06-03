<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Mission5-1</title>
</head>
<body>
    <?php
    // データベース名とホスト名を指定
    $dsn='mysql:dbname=データベース名;host=localhost';
    // ユーザ名
    $user='ユーザ名';
    // パスワード
    $password='パスワード';
    // array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)はデータベース操作でエラーが発生した場合に警告するためのオプション
    // これがあることで不具合があった時に問題の発見が容易になる
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    // テーブルの作成
    $sql = "CREATE TABLE IF NOT EXISTS BulletinBoard"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "timeclock datetime,"
    . "post_password char(16)"
    .");";
    $stmt = $pdo->query($sql);
    
    // 次に格納するところを入れる
    function GetNum($pdo)
    {
        $num=1;
        $sql='SELECT * FROM BulletinBoard';
        // 差し替えるパラメータを含めて記述したSQL文を準備
        // その差しけるパラメータの値を指定してから
        // SQL文を実行する
        $stmt=$pdo->query($sql);
        $results=$stmt->fetchAll();
        foreach($results as $row)
        {
    
            $num++;
        }
        return $num+1;
    }

    // 編集の場合名前とコメントを取得
    if(!empty($_POST["Editnumber"])&&$_POST["Editnumber"]>0)
    {
        // 編集番号の受け取り
        $Editnumber=htmlspecialchars($_POST["Editnumber"],ENT_QUOTES,'UTF-8');
        $edit_password=htmlspecialchars($_POST["edit_password"],ENT_QUOTES,'UTF-8');
        
        $edit_number=-1;
        $edit_name="";
        $edit_comment="";
        //$edit_password="";
        // データベースにあるか
        // SQL文
        $sql='SELECT * FROM BulletinBoard';
        // 差し替えるパラメータを含めて記述したSQL文を準備
        // その差しけるパラメータの値を指定してから
        // SQL文を実行する
        $stmt=$pdo->query($sql);
        $results=$stmt->fetchAll();
        foreach($results as $row)
        {
            // 条件にパスワードを入れる
            if($Editnumber==$row['id']&&$edit_password==$row['post_password'])
            {
                $edit_number=$Editnumber;
                $edit_name=$row['name'];
                $edit_comment=$row['comment'];
                $edit_password=$row['post_password'];
            }
        }

    }
    else
   {
       $edit_name="";
       $edit_comment="";
       $edit_password="";
       $edit_number=-1;
   }
    ?>
    <strong><font size="20">好きな歌手</font></strong>
    <!--送信フォーム-->
    <!--valueは初期値-->
    <!-- 名前・投稿内容・hidden属性で時間を送信 -->
    <form action="" method="post">
       名前:<input type="text" name="name" value="<?php echo $edit_name;?>" ><br>
        投稿内容:<input type="text" name="comment" value="<?php echo $edit_comment; ?>"><br>
        <input type="hidden" name="edit_number" value="<?php echo $edit_number;?>">
        <input type="hidden" name="timeclock" value="<?php echo date('Y-m-d H:i:s'); ?>">
        パスワード:<input type="text" name="post_password" value="" required><br>
        <input type="submit" name="submit"><br>
    </form>

    <!-- 削除フォーム -->
    <!-- 数字を送信 -->
    <form action="" method="post">
     削除番号:<input type="number" name="number" ><br>
     パスワード:<input type="text" name="delete_password" value="" required><br>
        <input type="submit" name="subnum" value="削除">
    </form>
    <!--編集番号指定フォーム-->
     <form action="" method="post">
     編集番号:<input type="number" name="Editnumber" ><br>
     パスワード:<input type="text" name="edit_password" value="" required><br>
        <input type="submit" name="subnum" value="編集">
    </form>
    <?php

    // 送信フォーム
    if(!empty($_POST["name"])&&!empty($_POST["comment"]))
    {
        // エスケープ処理
        $name=htmlspecialchars($_POST["name"],ENT_QUOTES,'UTF-8');
        $comment=htmlspecialchars($_POST["comment"],ENT_QUOTES,'UTF-8');
        $timeclock=htmlspecialchars($_POST["timeclock"],ENT_QUOTES,'UTF-8');
        $edit_number=htmlspecialchars($_POST["edit_number"],ENT_QUOTES,'UTF-8');
        $post_password=htmlspecialchars($_POST["post_password"],ENT_QUOTES,'UTF-8');
        
        // 編集の場合
        if($edit_number>=0&&$edit_number<GetNum($pdo))
        {
            $id=$edit_number;
            $sql='UPDATE BulletinBoard SET name=:name, comment=:comment, timeclock=:timeclock WHERE id=:id AND post_password=:post_password';
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':timeclock', $timeclock, PDO::PARAM_STR);
            $stmt->bindParam(':id',$id,PDO::PARAM_INT);
            $stmt->bindParam('post_password',$post_password,PDO::PARAM_STR);
            $stmt->execute();
        }
        // 新規フォーム
        else
        {
            $sql=$pdo->prepare("INSERT INTO BulletinBoard(name, comment,timeclock,post_password) values(:name, :comment,:timeclock,:post_password)");
            $sql->bindParam(':name', $name,PDO::PARAM_STR);
            $sql->bindParam(':comment',$comment, PDO::PARAM_STR);
            $sql->bindParam(':timeclock',$timeclock, PDO::PARAM_STR);
            $sql->bindParam(':post_password',$post_password, PDO::PARAM_STR);
            $sql->execute();
        }
    }

    // 削除フォーム
    elseif(!empty($_POST["number"])&&$_POST["number"]>0&&$_POST["number"]<GetNum($pdo))
    {
        $number=htmlspecialchars($_POST["number"],ENT_QUOTES,'UTF-8');
        $delete_password=htmlspecialchars($_POST["delete_password"],ENT_QUOTES,'UTF-8');

        $sql='delete from BulletinBoard where id=:number AND post_password=:delete_password';
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':number', $number, PDO::PARAM_INT);
        $stmt->bindParam(':delete_password',$delete_password, PDO::PARAM_STR);
        $stmt->execute();

    }

    // SQL文
    $sql='SELECT * FROM BulletinBoard';
    // 差し替えるパラメータを含めて記述したSQL文を準備
    // その差しけるパラメータの値を指定してから
    // SQL文を実行する
    $stmt=$pdo->query($sql);
    $results=$stmt->fetchAll();
    foreach($results as $row)
    {
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['timeclock'].'<br>';
        echo "<hr>";
    }

    ?>    



</body>
</html>