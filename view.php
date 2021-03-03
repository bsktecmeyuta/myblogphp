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
  <?php foreach($aryItem as $value): ?>
    <title><?php echo $value['title']; ?></title>
  <?php endforeach; ?>
</head>
<body>
  <?php foreach($aryItem as $value): ?>

    <h1><?php echo $value['title']; ?></h1>

    <p><?php echo $value['date']; ?></p>

    <div class="text">
      <?php echo nl2br($value['text']); ?>
    </div>

    <a href="index.php">戻る</a>
  
  <?php endforeach; ?>
</body>
</html>