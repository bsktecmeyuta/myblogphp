<?php
date_default_timezone_set("Asia/Tokyo");
$id=null;
$url= (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

include_once("sqlpdo.php"); //DB接続情報の読み込み
$pdo=connectdatebase();

$sql="SELECT * FROM contents ORDER BY date ASC";
$stmt=$pdo->query($sql);

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
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-JFM2WCEZW3"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-JFM2WCEZW3');
  </script>
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
              <div class="date"><div>閲覧数:<?php echo $value['accesscount']; ?></div>更新日:<?php echo $value['date']; ?></div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>
  </main>
  <div id="popup">
  <div id="close">× 閉じる</div>
    <label for="mailform">メール通知を受け取る</label>
    <form action="addmail.php" method="post">
      <input type="email" name="mailform" id="mailform" placeholder="sample@mail.com">
      <input type="submit" name="mailsubmit" value="送信">
    </form>    
  </div>
<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="jquery/program.js"></script>
</body>
</html>