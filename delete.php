<?php
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
    if(!empty($_POST['id'])&&!empty($_POST['title'])&&!empty($_POST['text'])&&!empty($_POST['date'])){
      // echo $_POST['id']."<br>".$_POST['title']."<br>".$_POST['text']."<br>".$_POST['date'];

      $title=$_POST['title'];
      $text=$_POST['text'];

      $title=htmlspecialchars($title, ENT_QUOTES);
      $title=preg_replace( '/\\r\\n|\\n|\\r/', '', $title);
      $text=htmlspecialchars($text, ENT_QUOTES);

      $stmt=$pdo->prepare('DELETE FROM contents WHERE id=:id AND title=:title AND text=:text AND date=:date');
      $stmt->execute(array(':id'=>$_POST['id'],':title'=>$title,':text'=>$text,':date'=>$_POST['date']));

      echo "<script>alert('削除しました');window.location.href='./contentsadmin.php';</script>";
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
  <title>記事削除</title>
  <link rel="stylesheet" href="style/write.css">
  <link rel="shortcut icon" href="image/oka_icon.ico" type="image/x-icon">
  <link rel="icon" href="image/oka_icon.ico">
</head>
<body>
<main>
  <header id="header">
    <h1><em>&lt;</em>記事削除<em>&gt;</em></h1>
  </header>
  <section id="section">
    <form action="" method="post">
      <div class="title">
        <label for="title"><em>&lt;</em>タイトル<em>&gt;</em></label>
      </div>
      <input type="text" name="title" id="title" placeholder="タイトルを入力" value="<?php echo $title; ?>" readonly>
      <div class="text">
        <label for="text"><em>&lt;</em>内容<em>&gt;</em></label>
      </div>
      <textarea name="text" id="text" cols="30" rows="10" placeholder="内容を入力" readonly><?php echo $text; ?></textarea>
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <input type="hidden" name="date" value="<?php echo $date; ?>">
      <div class="submit">
        <input type="submit" name="submit" value="削除">
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