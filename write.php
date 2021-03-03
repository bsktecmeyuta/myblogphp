<?php
// echo "hi";
date_default_timezone_set("Asia/Tokyo");

$id=null;
$title=null;
$text=null;
$tit=null;
$txt=null;
$date=null;
$send_flag=null;

$pdo=new PDO("mysql:dbname=myblog;host=localhost;  charset=utf8;","root","password");

if($pdo){
  // echo "OK";
}else{
  // echo "NO";
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

    echo "<script>alert('投稿完了');window.location.href = './write.php';</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/write.css">
  <title>投稿</title>
</head>
<body>
<main>
  <header>
    <h1><em>&lt;</em>投稿<em>&gt;</em></h1>
  </header>
  <section>
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
      </div>
    </form>
  </section>
</main>
</body>
</html>