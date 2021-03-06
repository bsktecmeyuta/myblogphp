<?php
// echo "hello";
// echo $_GET['id'];

$pdo=new PDO("mysql:dbname=myblog;host=localhost;  charset=utf8;","root","password");

if($pdo){
  // echo "OK";
}else{
  // echo "NO";
}

if(!empty($_GET['id']) && empty($_POST['id'])){
  $contents_id=(int)htmlspecialchars($_GET['id'],ENT_QUOTES);
  $sql="SELECT * FROM contents WHERE id=:id";

  $sth=$pdo->prepare($sql);
  $sth->bindParam(':id',$contents_id);

  $sth->execute();

  $aryItem = $sth -> fetchAll(PDO::FETCH_ASSOC);

  if(empty($aryItem)){
    echo "<script>alert('記事が見つかりませんでした');window.location.href = './index.php';</script>";
  }

  foreach($aryItem as $value){
    $title=$value['title'];
    $text=$value['text'];
    $date=$value['date'];

  }

}else{
  echo "<script>window.location.href = './index.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="style/view.css">
</head>
<body>
  <main>
    <header>
      <h1><em>&lt;</em><?php echo $title; ?><em>&gt;</em></h1>
      <p><u><?php echo "更新日:".$date;?></u></p>
    </header>
    <section>
      <p><?php echo nl2br($text); ?></p>
      <a href="index.php">戻る</a>
    </section>
  </main>
</body>
</html>