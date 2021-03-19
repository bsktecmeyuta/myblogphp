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

$sql="SET @i := 0; UPDATE myblogmaillist SET id = (@i := @i +1);";
$stmt2=$pdo->query($sql);

if(!empty($_POST['deletemail'])){
  // echo $_POST['mailid'];
  $mailid= $_POST['mailid'];

  if(!empty($mailid)){
    $stmt=$pdo->prepare("DELETE FROM myblogmaillist WHERE id=:id");
    $stmt->execute(array(':id'=>$mailid));

    echo "<script>alert('削除しました');window.location.href='./mailadmin.php';</script>";
  }

}

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
        <td></td>
      </tr>
      <?php $num =1; ?>
      <?php foreach($stmt as $value): ?>
      
        <tr>
          <td><?php echo $num; ?></td>
          <td><?php echo $value['mails']; ?></td>
          <td><?php echo $value['date']; ?></td>
          <td>
            <form action="" method="post">
              <input type="hidden" name="mailid" value="<?php echo $value['id'] ?>">
              <input type="submit" name="deletemail" value="削除">
            </form>
          </td>
        </tr>
      <?php $num++;?>
      <?php endforeach; ?>
    </table>
    <a href="./write.php">戻る</a>
  </main>
</body>
</html>