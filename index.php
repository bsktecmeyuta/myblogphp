<?php
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

$sql="SELECT * FROM contents ORDER BY date ASC";
$stmt=$pdo->query($sql);

$sql="SET @i := 0; UPDATE contents SET id = (@i := @i +1);";
$stmt2=$pdo->query($sql);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/main.css">
  <title>My Blog</title>
</head>
<body>
  <main>
    <header id="header">
      <h1><em>&lt;</em>My Blog<em>&gt;</em></h1>
    </header>
    <section id="section">
      <div class="list">
      <p><em>&lt;</em>記事一覧<em>&gt;</em></p>
        <ul>
        <?php if(!empty($stmt)): ?>
          <?php foreach($stmt as $value): ?>
            <li>
              <a href="view.php?id=<?php echo $value['id']; ?>"><?php echo $value['title']; ?></a>
              <div class="date">更新日:<?php echo $value['date']; ?></div>
            </li>
          <?php endforeach; ?>
        <?php else: ?>
          <p>記事がありません</p>
        <?php endif; ?>
        </ul>
      </div>
    </section>
  </main>
<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="jquery/program.js"></script>
</body>
</html>