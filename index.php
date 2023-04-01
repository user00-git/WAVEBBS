<?php 
    //タイムゾーンを定義
    date_default_timezone_set("ASIA/Tokyo");
    //queryのデータを格納する配列を用意する。
    $comment_array = array();
    $pdo = null;
    $stmt = null;
    $error_messages = array();
   
   //DB接続
   try{
    $pdo = new PDO('mysql:host=localhost;dbname=bbs-db', 'root', '');
    echo "Good morning, and in case I don't see ya, good afternoon, good evening, and good night! ";
 } catch (PDOException $e) {
     echo "!!failure Don't have connection database " . $e-> getMessage();
     exit;
 }
    //フォームを打ち込んだ時
    if(!empty($_POST["submitButton"])){
    
    //名前のチェック   
     if(empty($_POST["username"])){
        echo "Please enter a valid name";
        $error_messages["username"] = "please enter a vaild name";
       }
    //コメントのチェック
    if(empty($_POST["comment"])){
        echo "Please enter a comment";
        $error_messages["comment"] = "please enter a comment";
    }
       
    if(empty($error_messages)){
        $postDate = date("Y-m-d H-i-s");
        
        try{
            $stmt = $pdo->prepare("INSERT INTO `bbs-table` (`username`, `comment`, `postDate`) VALUES (:username, :comment, :postDate)");
            $stmt->bindParam(':username', $_POST['username']);
            $stmt->bindParam(':comment', $_POST['comment']);
            $stmt->bindParam(':postDate', $postDate);
    
            $stmt->execute();

        }catch(PDOException $e){
            echo $e-> getMessage();
            exit;
        }
    }

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
      ?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="chorome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>WAVE BBS</title>
</head>
<body>
<h1 class="title">WAVE BBS</h1>
<hr>
<div class="boardWrapper">
   <section>
   <!-- foreach 文で$comment_arrayを取り出す -->
   <?php foreach($comment_array as $comment): ?>
    <article>
        <div class="wrapper">
            <div class="nameArea">
                <span>名前:</span>
                <p class="username"><?php echo $comment["username"]; ?></p>
                <time>:</time>
                <p><?php echo $comment["postDate"]; ?></p>
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