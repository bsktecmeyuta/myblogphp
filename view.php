<?php
// echo "hello";
// echo $_GET['id'];

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

if(!empty($_GET['id']) && empty($_POST['id'])){
  $contents_id=(int)htmlspecialchars($_GET['id'],ENT_QUOTES);
  $sql="SELECT * FROM contents WHERE id=:id";

  $sth=$pdo->prepare($sql);
  $sth->bindParam(':id',$contents_id);

  $sth->execute();

  $aryItem = $sth -> fetchAll(PDO::FETCH_ASSOC);

  if(empty($aryItem)){
    echo "<script>alert('記事が見つかりませんでした');window.location.href = './index.php';</script>記事が見つかりませんでした";
  }

  foreach($aryItem as $value){
    $id=$value['id'];
    $title=$value['title'];
    $text=$value['text'];
    $date=$value['date'];
    $keywords=$value['keywords'];
    $accesscount=$value['accesscount'];
  }

  $accesscount++;
  $sql="UPDATE contents SET title=title,text=text,date=date,keywords=keywords,accesscount=:accesscount WHERE id=:id";
  $stmt=$pdo->prepare($sql);
  $stmt->execute(array(':accesscount'=>$accesscount,':id'=>$id));

}else{
  echo "<script>window.location.href = './index.php';</script>";
}

$num =$_GET['id'];
$num =( int )$num;
// echo $num;

$url= (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$iconurl= (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'];


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="style/view.css">
  <link rel="shortcut icon" href="image/oka_icon.ico" type="image/x-icon">
  <link rel="icon" href="image/oka_icon.ico">
  <meta name="keywords" content="<?php echo $keywords; ?>">
  <meta name="description" content="<?php echo $text; ?>">
  <meta property="og:title" content="<?php echo $title; ?>" />
  <meta property="og:type"        content="website" />
  <meta property="og:url"         content="<?php echo $url; ?>" />
  <meta property="og:description" content="<?php echo $text; ?>" />
  <meta property="og:site_name" content="<?php echo $title; ?>" />
  <meta property="og:image" content="http://or0e9abi5m.php.xdomain.jp/myblog/image/oka_icon.ico" />
  <meta name="twitter:card"       content="summary">
</head>
<body>
  <main>
    <header id="header">
      <h1><em>&lt;</em><?php echo $title; ?><em>&gt;</em></h1>
      <p><u><?php echo "更新日:".$date;?></u></p>
      <p class="twitterbutton"><a href="https://twitter.com/share?url=<?php echo $url; ?>&text=<?php echo $title; ?>&count=none&lang=ja" target="_blanck">ツイート</a></p>
      <p>閲覧数:<?php echo $accesscount; ?></p>
      <a href="index.php">&lt;戻る</a>
    </header>
    <section id=section>
      <p><?php echo nl2br($text); ?></p>
      <a href="view.php?id=<?php echo $num-1; ?>">&lt;</a>
      <a href="index.php">戻る</a>
      <a href="view.php?id=<?php echo $num+1; ?>">&gt;</a>
    </section>
  </main>
<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="jquery/program.js"></script>
</body>
</html>