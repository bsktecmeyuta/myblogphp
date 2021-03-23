<?php
date_default_timezone_set("Asia/Tokyo");
$id=null;
$url= (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

include_once('sqlpdo.php');
$pdo=connectdatebase();

// $sql="SET @i := 0; UPDATE myblogmaillist SET id = (@i := @i +1);";
// $stmt=$pdo->query($sql);

if(!empty($_POST['mailform'])){
  $mail=htmlspecialchars($_POST['mailform'], ENT_QUOTES);
  // $mail  = preg_replace("/( |　)/", "", $mail );
  $date=date("Y/m/d H:i:s");

  // echo $id."<br>".$mail."<br>".$date;

  if(!empty($mail)){

    $sql = "SELECT * 
    FROM myblogmaillist 
    WHERE mails=:mails";
  
    //prepareでSQL文をセット
    $sth = $pdo -> prepare($sql);
  
    //bindValueで値をセット　:priceを値に置き換える
    $sth -> bindParam(':mails', $mail);
  
    //executeで実行
    $sth -> execute();
  
    //結果セットから配列を取得
    $aryItem = $sth -> fetchAll(PDO::FETCH_ASSOC);
    // var_dump($aryItem) ;
  
    if(!empty($aryItem)){
      echo "<script>alert('そのメールアドレスは登録されています');</script>";
      goto end;
    }

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

    // 送信する
    if(mail($to, $subject, $message, implode("\r\n", $headers))){
      // echo "OK";
    }else{
      // echo "NO";
    }

    echo "<script>alert('確認メールを送信しました');window.location.href = './index.php';</script>";



  }
    
  }else{
    end:
    echo "<script>window.location.href = './index.php';</script>";

  
}
?>