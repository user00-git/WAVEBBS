<?php 
    $comment_array = array();
    if(!empty($_POST["submitButton"])){
        echo $_POST["username"];
        echo $_POST["comment"];
    }

//DB接続
    try{
       $pdo = new PDO('mysql:host=localhost;dbname=bbs-db', 'root', '');
    }catch (PDOException $e){
        echo $e-> getMessage();
    }
// テストコード
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=bbs-db', 'root', '');
        echo "データベースに接続しました。";
      } catch (PDOException $e) {
        echo "データベースの接続に失敗しました。" . $e->getMessage();
        exit;
      }
      
      //DBからコメントを取得する
      $SQL = "SELECT * FROM `bbs-table`";
      $comment_array = $pdo->query($SQL);
      
      if (!$comment_array) {
        echo "クエリの実行に失敗しました。" . print_r($pdo->errorInfo(), true);
        exit;
      }
      
      //DBの接続を閉じる
      $pdo = null;
      




    //DBからコメントを取得する
    // $SQL = "SELECT * FROM 'bbs-table';";
    // $comment_array = $pdo -> query("SELECT * FROM 'bbs-table'");
// //DBからコメントを取得する
//     $SQL = "SELECT * FROM bbs-table;";
//     $comment_array = $pdo -> query($SQL);


//DBの接続を閉じる
    $pdo = null;
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="chorome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>PHP BBS</title>
</head>
<body>
<h1 class="title">PHP BBS</h1>
<hr>
<div class="boardWrapper">
   <section>
   
   <?php foreach($comment_array as $comment): ?>
    <article>
        <div class="wrapper">
            <div class="nameArea">
                <span>名前:</span>
                <p class="username"><?php echo $comment["username"]; ?></p>
                <time>:2022/4/4</time>
            </div>
            <p class="comment"><?php echo $comment["comment"]?></p>
        </div>
    </article>
    <?php endforeach; ?>
    </section>
    <form class="formWrapper" method="POST" >
    <div>
        <input type="submit" value="書き込む" name="submitButton">
        <label for="">名前:</label>
        <input type="text" name="username">
    </div>
    <div>
        <textarea class="commentTextArea" method = "POST" name="comment"></textarea>
    </div>
    </form>
</body>
</html>