<?php
session_start();
include_once('sqlpdo.php');
$pdo=connectdatebase();

if(!empty($_SESSION['login_flag'])){
  $fileopen=fopen("password.txt","r");
  $line=fgets($fileopen);
  // echo $line;
}else{
  echo "<script>window.location.href = './write.php';</script>";
}

$sql="SELECT * FROM myblogmaillist ORDER BY id ASC";
$stmt=$pdo->query($sql);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>メール管理</title>
  <link rel="stylesheet" href="style/mailadmin.css">
</head>
<body>
  <header>
    <h1><em>&lt;</em>メール管理<em>&gt;</em></h1>
  </header>
  <main>
    <table>
      <tr>
        <td>id</td>
        <td>email</td>
        <td>date</td>
      </tr>
      <?php foreach($stmt as $value): ?>
        <tr>
          <td><?php echo $value['id']; ?></td>
          <td><?php echo $value['mails']; ?></td>
          <td><?php echo $value['date']; ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
    <a href="./write.php">戻る</a>
  </main>
</body>
</html>