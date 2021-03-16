<?php
date_default_timezone_set("Asia/Tokyo");
$id=null;
$url= (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
try {
  // $dbh = new PDO($dsn, $user, $password);
  // $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo=new PDO("mysql:dbname=myblog;host=localhost;  charset=utf8;","root","password");
} catch (PDOException $e) {
  $pdo=new PDO("mysql:dbname=or0e9abi5m_onlinemeeting;host=157.112.147.201; port=3306; charset=utf8;","or0e9abi5m_1","userlistid");
  // echo 'Connection failed: ' . $e->getMessage();
}

if(!empty($_POST['mailform'])){
  $mail=htmlspecialchars($_POST['mailform'], ENT_QUOTES);
  // $mail  = preg_replace("/( |　)/", "", $mail );
  $date=date("Y/m/d H:i:s");

  // echo $id."<br>".$mail."<br>".$date;

  if(!empty($mail)){

    // $regist=$pdo->prepare("INSERT INTO myblogmaillist (id,mails,date) VALUES (:id,:mails,:date)");
    // $regist->bindParam(':id',$id);
    // $regist->bindParam(':mails',$mail);
    // $regist->bindParam(':date',$date);

    // $regist->execute();

    $sql=$pdo->prepare("INSERT INTO myblogmaillist(id,mails,date) VALUES(:id,:mails,:date)");
    $sql->bindParam(":id",$id);
    $sql->bindParam(':mails',$mail);
    $sql->bindParam(':date',$date);

    // $sql->execute();
    $check=$sql->execute();
    if($check){
    // print '成功！';
    }else{
    // print '失敗！';
    }

    $to = $mail; // カンマに注意

    // 表題
    $subject = "メール通知登録完了";

    // 本文
    $message = "
      <html>
      <head>
        <title>メール通知登録完了しました。</title>
      </head>
      <body>
        <p>メール通知登録完了しました。</p>  
        <p>サイトURL</p>   
        <a href='http://or0e9abi5m.php.xdomain.jp/myblog/index.php'>http://or0e9abi5m.php.xdomain.jp/myblog/index.php</a>
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
    // $headers[] = 'Content-type: text/html; charset=iso-2022-jp';
    $headers[] = 'Content-type: text/html; charset=utf-8';

    // // 送信する
    if(mail($to, $subject, $message, implode("\r\n", $headers))){
      // echo "OK";
    }else{
      // echo "NO";
    }

    echo "<script>alert('確認メールを送信しました');window.location.href = './index.php';</script>";

  }else{
    echo "<script>window.location.href = './index.php';</script>";
    
  }

  
}
?>