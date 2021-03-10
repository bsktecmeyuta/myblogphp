<?php
$send_flag=null;
session_start();
if(!empty($_SESSION['login_flag'])){
  $fileopen=fopen("password.txt","r");
  $line=fgets($fileopen);
  // echo $line;
}else{
  echo "<script>window.location.href = './write.php';</script>";
}

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
  $id=$_POST['id'];
  $new_title=$_POST['title'];
  $new_text=$_POST['text'];
  // echo $title."<br>".$text;
  // if(!empty($_POST['']))
  $tit=htmlspecialchars($new_title, ENT_QUOTES);
  $tit=preg_replace( '/\\r\\n|\\n|\\r/', '', $tit);
  $tit  = preg_replace("/( |　)/", "", $tit );
  $txt=htmlspecialchars($new_text, ENT_QUOTES);
  $txt=preg_replace( '/\\r\\n|\\n|\\r/', '', $txt);
  $txt  = preg_replace("/( |　)/", "", $txt );

  $new_title=htmlspecialchars($new_title, ENT_QUOTES);
  $new_title=preg_replace( '/\\r\\n|\\n|\\r/', '', $new_title);
  $new_text=htmlspecialchars($new_text, ENT_QUOTES);
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

  if(empty($send_flag)){


    $sql="UPDATE contents SET title=:title,text=:text,date=date WHERE id=:id";

    $stmt=$pdo->prepare($sql);

    $stmt->execute(array(':title'=>$new_title,':text'=>$new_text,'id'=>$id));

    echo "<script>alert('編集完了');window.location.href = './contentsadmin.php';</script>";
  }else{
    echo "<script>window.location.href = './edit.php';</script>";
  }
}

if(!empty($_POST['id'])){
  $contents_id=(int)htmlspecialchars($_POST['id'],ENT_QUOTES);
  $sql="SELECT * FROM contents WHERE id=:id";

  $sth=$pdo->prepare($sql);
  $sth->bindParam(':id',$contents_id);

  $sth->execute();

  $aryItem = $sth -> fetchAll(PDO::FETCH_ASSOC);

  if(empty($aryItem)){
    echo "<script>alert('記事が見つかりませんでした');window.location.href = './contentsadmin.php';</script>";
  }

  foreach($aryItem as $value){
    $id=$value['id'];
    $title=$value['title'];
    $text=$value['text'];
    $date=$value['date'];

  }

}else{
  echo "<script>window.location.href = './contentsadmin.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>編集ページ</title>
  <link rel="stylesheet" href="style/write.css">
</head>
<body>
<main>
<header id="header">
    <h1><em>&lt;</em>編集<em>&gt;</em></h1>
  </header>
  <section id="section">
    <form action="" method="post">
      <div class="title">
        <label for="title"><em>&lt;</em>タイトル<em>&gt;</em></label>
      </div>
      <input type="text" name="title" id="title" placeholder="タイトルを入力" value="<?php echo $title; ?>">
      <div class="text">
        <label for="text"><em>&lt;</em>内容<em>&gt;</em></label>
      </div>
      <textarea name="text" id="text" cols="30" rows="10" placeholder="内容を入力"><?php echo $text; ?></textarea>
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <input type="hidden" name="date" value="<?php echo $date; ?>">
      <div class="submit">
        <input type="submit" name="submit" value="完了">
        <!-- <input type="submit" name="logout" value="ログアウト"> -->
      </div>
      <!-- <a href="changepassword.php">パスワード変更</a> -->
      <a href="contentsadmin.php">戻る</a>
    </form>
  </section>
</main>
<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="jquery/program.js"></script>
</body>
</html>