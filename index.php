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
// $id_list[] = $stmt->fetchAll();

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
  <link rel="shortcut icon" href="image/oka_icon.ico" type="image/x-icon">
  <link rel="icon" href="image/oka_icon.ico">
  <title>ゴマ団子あげる</title>
  <meta name="description" content="ブログサイト『ゴマ団子あげる』">
  <meta property="og:title" content="ブログサイト『ゴマ団子あげる』" />
  <meta property="og:type"        content="website" />
  <meta property="og:url"         content="http://or0e9abi5m.php.xdomain.jp/myblog/index.php" />
  <meta property="og:description" content="ブログサイト『ゴマ団子あげる』" />
  <meta property="og:site_name" content="ブログサイト『ゴマ団子あげる』" />
  <meta property="og:image" content="http://or0e9abi5m.php.xdomain.jp/myblog/image/oka_icon.ico" />
  <meta name="twitter:card"       content="summary">
</head>
<body>
  <main>
    <header id="header">
      <h1><em>&lt;</em>ゴマ団子あげる<em>&gt;</em></h1>
    </header>
    <section id="section">
      <div class="list">
      <p><em>&lt;</em>記事一覧<em>&gt;</em></p>
        <ul>
          <?php foreach($stmt as $value): ?>
            <li>
              <a href="view.php?id=<?php echo $value['id']; ?>"><?php echo $value['title']; ?></a>
              <div class="date">更新日:<?php echo $value['date']; ?></div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>
  </main>
<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="jquery/program.js"></script>
</body>
</html>