<?php
// echo "hi";
date_default_timezone_set("Asia/Tokyo");
session_start();
$id=null;
$title=null;
$text=null;
$tit=null;
$txt=null;
$date=null;
$send_flag=null;
// $_SESSION['login_flag']=null;
// $pdo=new PDO("mysql:dbname=myblog;host=localhost;  charset=utf8;","root","password");

// if($pdo){
//   // echo "OK";
// }else{
//   // echo "NO";
//   $pdo=new PDO("mysql:dbname=or0e9abi5m_onlinemeeting;host=157.112.147.201; port=3306; charset=utf8;","or0e9abi5m_1","userlistid");
// }

try {
  // $dbh = new PDO($dsn, $user, $password);
  // $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo=new PDO("mysql:dbname=myblog;host=localhost;  charset=utf8;","root","password");
} catch (PDOException $e) {
  $pdo=new PDO("mysql:dbname=or0e9abi5m_onlinemeeting;host=157.112.147.201; port=3306; charset=utf8;","or0e9abi5m_1","userlistid");
  // echo 'Connection failed: ' . $e->getMessage();
}

if(!empty($_POST['submit'])){
  $title=$_POST['title'];
  $text=$_POST['text'];
  // echo $title."<br>".$text;
  // if(!empty($_POST['']))
  $tit=htmlspecialchars($title, ENT_QUOTES);
  $tit=preg_replace( '/\\r\\n|\\n|\\r/', '', $tit);
  $tit  = preg_replace("/( |　)/", "", $tit );
  $txt=htmlspecialchars($text, ENT_QUOTES);
  $txt=preg_replace( '/\\r\\n|\\n|\\r/', '', $txt);
  $txt  = preg_replace("/( |　)/", "", $txt );

  $title=htmlspecialchars($title, ENT_QUOTES);
  $title=preg_replace( '/\\r\\n|\\n|\\r/', '', $title);
  $text=htmlspecialchars($text, ENT_QUOTES);
  if(empty($tit)){
    // echo $txt;
    // var_dump($txt);
    // echo $_POST['form_text'];
    // echo "title is none";
    echo "<script>alert('タイトルが空です');</script>";
    // goto out;
    $send_flag=true;
  }
  if(empty($txt)){
    // echo "text is none";
    echo "<script>alert('内容が空です');</script>";
    $send_flag=true;
  }
  // out:
  if(empty($send_flag)){
    // echo "go";
    $date=date("Y/m/d H:i:s");
    $sql=$pdo->prepare("INSERT INTO contents(id,title,text,date) VALUE(:id,:title,:text,:date)");
    $sql->bindParam(":id",$id);
    $sql->bindParam(":title",$title);
    $sql->bindParam(":text",$text);
    $sql->bindParam(":date",$date);

    $sql->execute();

    $sql="SET @i := 0; UPDATE contents SET id = (@i := @i +1);";
    $stmt2=$pdo->query($sql);

    echo "<script>alert('投稿完了');window.location.href = './write.php';</script>";
  }
  echo "<script>window.location.href = './write.php';</script>";
}

if(!empty($_POST['login_btn'])){
  $login_password= $_POST['password'];
  $fileopen=fopen("password.txt","r");
  $line=fgets($fileopen);
  // echo $login_password."<br>".$line;
  if($line==$login_password){
    $_SESSION['login_flag']=true;
  }
}

if(!empty($_POST['logout'])){
  unset($_SESSION['login_flag']);
  echo "<script>alert('ログアウトしました');</script>";
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/write.css">
  <link rel="shortcut icon" href="image/oka_icon.ico" type="image/x-icon">
  <link rel="icon" href="image/oka_icon.ico">
  <title>投稿</title>
</head>
<body>
<main>
<?php if(empty($_SESSION['login_flag'])): ?>
  <form action="" method="POST">
    <label for="password"><h1>ログイン</h1></label>
    <input type="password" name="password" id="password" placeholder="パスワードを入力">
    <input type="submit" name="login_btn" value="ログイン">
  </form>
<?php else: ?>
  <header id="header">
    <h1><em>&lt;</em>投稿<em>&gt;</em></h1>
  </header>
  <section id="section">
    <form action="" method="post">
      <div class="title">
        <label for="title"><em>&lt;</em>タイトル<em>&gt;</em></label>
      </div>
      <input type="text" name="title" id="title" placeholder="タイトルを入力">
      <div class="text">
        <label for="text"><em>&lt;</em>内容<em>&gt;</em></label>
      </div>
      <textarea name="text" id="text" cols="30" rows="10" placeholder="内容を入力"></textarea>
      <div class="submit">
        <input type="submit" name="submit" value="投稿">
        <input type="submit" name="logout" value="ログアウト">
      </div>
      <a href="changepassword.php">パスワード変更</a>
      <a href="contentsadmin.php">記事編集</a>
    </form>
  </section>
<?php endif; ?>
</main>
<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="jquery/program.js"></script>
</body>
</html>