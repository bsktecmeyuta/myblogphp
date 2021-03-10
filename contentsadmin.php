<?php
session_start();
// echo "say hello";
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