<?php
session_start();

include_once("sqlpdo.php"); //DB接続情報の読み込み
$pdo=connectdatebase();

if(!empty($_SESSION['login_flag'])){
  $fileopen=fopen("password.txt","r");
  $line=fgets($fileopen);
  // echo $line;
}else{
  echo "<script>window.location.href = './write.php';</script>";
}

$sql="SELECT * FROM contents ORDER BY date ASC";
$stmt=$pdo->query($sql);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>記事編集</title>
  <link rel="stylesheet" href="style/main.css">
  <link rel="shortcut icon" href="image/oka_icon.ico" type="image/x-icon">
  <link rel="icon" href="image/oka_icon.ico">
</head>
<body>
  <main>
    <header id="header">
      <h1><em>&lt;</em>記事編集<em>&gt;</em></h1>
    </header>
    <section id="section">
      <div class="list">
      <p><em>&lt;</em>記事一覧<em>&gt;</em></p>
        <ul>
          <?php foreach($stmt as $value): ?>
            <li>
              <!-- <a href="view.php?id=<?php echo $value['id']; ?>"> -->
              <div>
                <?php echo $value['title']; ?>
              </div>
              <!-- </a> -->
              <div class="date">
                <div class="forms">
                  <form action="edit.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $value['id']; ?>">
                    <input type="submit" value="編集">
                  </form>
                  <form action="delete.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $value['id']; ?>">
                    <input type="submit" value="削除">
                  </form>
                </div>
                 
                 <!-- <div class="date2"> -->
                  閲覧数:<?php echo $value['accesscount']; ?>
                  更新日:<?php echo $value['date']; ?>
                 <!-- </div> -->
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="backto"><a href="write.php">戻る</a></div>
    </section>
  </main>
<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="jquery/program.js"></script>
</body>
</html>