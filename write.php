<?php
date_default_timezone_set("Asia/Tokyo");
session_start();
$id=null;
$title=null;
$text=null;
$tit=null;
$txt=null;
$date=null;
$send_flag=null;

include_once("sqlpdo.php"); //DB接続情報の読み込み
$pdo=connectdatebase();

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

if(!empty($_POST['submit'])){
  $title=$_POST['title'];
  $text=$_POST['text'];
  $keywords=$_POST['keywords'];
  // echo $title."<br>".$text;
  // if(!empty($_POST['']))
  $tit=htmlspecialchars($title, ENT_QUOTES);
  $tit=preg_replace( '/\\r\\n|\\n|\\r/', '', $tit);
  $tit  = preg_replace("/( |　)/", "", $tit );
  $txt=htmlspecialchars($text, ENT_QUOTES);
  $txt=preg_replace( '/\\r\\n|\\n|\\r/', '', $txt);
  $txt  = preg_replace("/( |　)/", "", $txt );
  $key=htmlspecialchars($keywords, ENT_QUOTES);
  $key=preg_replace( '/\\r\\n|\\n|\\r/', '', $key);
  $key  = preg_replace("/( |　)/", "", $key );

  $title=htmlspecialchars($title, ENT_QUOTES);
  $title=preg_replace( '/\\r\\n|\\n|\\r/', '', $title);
  $text=htmlspecialchars($text, ENT_QUOTES);
  $keywords=htmlspecialchars($keywords, ENT_QUOTES);
  if(empty($tit)){
    // echo $txt;
    // var_dump($txt);
    // echo $_POST['form_text'];
    // echo "title is none";
    echo "<script>alert('タイトルが空です');</script>";
    // goto out;
    $send_flag=true;
  }
  if(empty($txt)){
    // echo "text is none";
    echo "<script>alert('内容が空です');</script>";
    $send_flag=true;
  }
  // out:
  if(empty($send_flag)){
    // echo "go";
    $date=date("Y/m/d H:i:s");
    $sql=$pdo->prepare("INSERT INTO contents(id,title,text,date,keywords) VALUES(:id,:title,:text,:date,:keywords)");
    $sql->bindParam(":id",$id);
    $sql->bindParam(":title",$title);
    $sql->bindParam(":text",$text);
    $sql->bindParam(":date",$date);
    $sql->bindParam(":keywords",$keywords);

    $sql->execute();

    // $sql="SET @i := 0; UPDATE contents SET id = (@i := @i +1);";
    // $stmt2=$pdo->query($sql);

    $sql="SELECT * FROM myblogmaillist";
    $sth=$pdo->query($sql);

    foreach($sth as $value){

      $to = $value['mails']; // カンマに注意
      $url="http://or0e9abi5m.php.xdomain.jp/myblog/";

      // 表題
      $subject = $title;
  
      // 本文
      $message = "
        <html>
        <head>
          <title>新記事が投稿されました</title>
        </head>
        <body>
          <p>新記事が投稿されました</p>  
          <p>サイトURL</p>   
          <a href='{$url}'>{$url}</a>
          <!--<p>後日ZOOMのリンクを送信します。</p>
          <table>
            <tr>
              <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
            </tr>
            <tr>
              <td>Johny</td><td>10th</td><td>August</td><td>1970</td>
            </tr>
            <tr>
              <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
            </tr>
          </table>-->
        </body>
        </html>
      ";
  
      // HTML メールを送信するには Content-type ヘッダが必須
      $headers[] = 'MIME-Version: 1.0';
      $headers[] = 'Content-type: text/html; charset=utf-8';
  
      // 送信する
      if(mail($to, $subject, $message, implode("\r\n", $headers))){
        // echo "OK";
      }else{
        // echo "NO";
      }

    }

    echo "<script>alert('投稿完了');window.location.href = './write.php';</script>";
  }
  echo "<script>window.location.href = './write.php';</script>";
}

// ワンタイムパッド
$pad = [
  11,10,12,20,148,22,87,91,239,187,206,215,103,207,192,46,75,243,
  204,61,361,121,210,145,167,108,78,166,129,109,239,138,134,150,196,
  217,63,158,201,204,66,181,198,54,0,0,130,163,212,57,167,
  169,115,170,50,109,116,173,177,252,242,233,3,33,28,139,73,
];

// ワンタイムパッドで暗号化
function convert($str, $pad) {
  $res = "";
  for ($i = 0; $i < strlen($str); $i++) {
    // 一文字取り出し、ASCIIコードに変換
    $c = ord(substr($str, $i, 1));
    // XORで暗号化
    $cx = $c ^ $pad[$i];
    // ASCIIコードを文字に変換
    $res .= chr($cx);
  }
  return $res;
}

if(!empty($_POST['login_btn'])){
  $login_password= $_POST['password'];
  $fileopen=fopen("password.txt","r");
  $line=fgets($fileopen);
  $line=convert($line,$pad);
  // echo $login_password."<br>".$line;
  if($line==$login_password){
    $_SESSION['login_flag']=true;
  }
}

if(!empty($_POST['logout'])){
  unset($_SESSION['login_flag']);
  echo "<script>alert('ログアウトしました');window.location.href='./write.php';</script>";
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/write.css">
  <link rel="shortcut icon" href="image/oka_icon.ico" type="image/x-icon">
  <link rel="icon" href="image/oka_icon.ico">
  <title>投稿</title>
</head>
<body>
<main>
<?php if(empty($_SESSION['login_flag'])): ?>
<header id="header">
    <label for="password"><h1><em>&lt;</em>ログイン<em>&gt;</em></h1></label>
</header>
<section id="section">
  <form action="" method="POST">
    <input type="password" name="password" id="password" placeholder="パスワードを入力">
    <input type="submit" name="login_btn" value="ログイン">
  </form>
</section>

<?php else: ?>
  <header id="header">
    <h1><em>&lt;</em>投稿<em>&gt;</em></h1>
  </header>
  <section id="section">
    <form action="" method="post">
      <div class="title">
        <label for="title"><em>&lt;</em>タイトル<em>&gt;</em></label>
      </div>
      <input type="text" name="title" id="title" placeholder="タイトルを入力">
      <div class="keywords">
        <label for="keywords"><em>&lt;</em>キーワード<em>&gt;</em></label>
      </div>
      <input type="text" name="keywords" id="keywords" placeholder="キーワード(カンマで区切る)">
      <div class="text">
        <label for="text"><em>&lt;</em>内容<em>&gt;</em></label>
      </div>
      <textarea name="text" id="text" cols="30" rows="10" placeholder="内容を入力"></textarea>
      <div class="submit">
        <input type="submit" name="submit" value="投稿">
        <input type="submit" name="logout" value="ログアウト">
      </div>
      <a href="changepassword.php">パスワード変更</a>
      <a href="contentsadmin.php">記事編集</a>
    </form>
  </section>
<?php endif; ?>
</main>
<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="jquery/program.js"></script>
</body>
</html>