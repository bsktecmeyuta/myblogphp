<?php
  if(!empty($_POST['sub'])){
    //言語と文字コードの使用宣言
    mb_language("ja");
    mb_internal_encoding("UTF-8");

    // 宛先
    $to = $_POST['mail'];

    // 件名
    $subject = "メールの送信テスト";

    // 本文
    $text = "こんにちは。<br>\nこちらはテストメールです。GRAYCODE";

    //メール送信
    $response = mb_send_mail( $to, $subject, $text);
  }
  if(!empty($_POST['sub2'])){
  mb_internal_encoding("utf-8");
  
  //宛先、Fromを設定
  $to = $_POST['mail'];
  $fromname = mb_encode_mimeheader("送信者名");
  $from = "fromaddress@example.com";
  
  //headerを設定
  $charset = "UTF-8";
  $headers['MIME-Version'] 	= "1.0";
  $headers['Content-Type'] 	= "text/plain; charset=".$charset;
  $headers['Content-Transfer-Encoding'] 	= "8bit";
  // $headers['From'] 		= '"'.$fromname.'"<'.$from.'>"';
  
  //headerを編集
  foreach ($headers as $key => $val) {
    $arrheader[] = $key . ': ' . $val;
  }
  $strHeader = implode("\n", $arrheader);
  
  //件名を設定（JISに変換したあと、base64エンコードをしてiso-2022-jpを指定する）
  $subject = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding("test","JIS","UTF-8"))."?=";
  
  //本文を設定
  $body = "<h1>test</h1>";
  
  //送ります！
  mail(
    $to,
    $subject,
    $body,
    $strHeader
  );
  }
  
  if(!empty($_POST['sub3'])){
    $mail_from      = 'test@example.com';
    $mail_to        = $_POST['mail'];
    $mail_from_name = '送信者の名前';

    $subject = '件名';

    $body_text = 'test';
    $body_html = '<h1>test</h1><br><h2>test</h2>';

    $parameter = "-f ".$mail_from;

    $boundary = "--".uniqid(rand(),1);

    // ヘッダー情報
    $headers = '';
    $headers .= 'Content-Type: multipart/alternative; boundary="' . $boundary . '"' . "\r\n";
    $headers .= 'Content-Transfer-Encoding: binary' . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    // $headers .= "From: " . mb_encode_mimeheader($mail_from_name) . "<" . $mail_from . ">" . "\r\n";
    // 送信者名を指定しない場合は次のよう
    // $headers .= "From: " . $mail_from . "\r\n";

    // メッセージ部分
    $message = '';
    $message .= '--' . $boundary . "\r\n";
    $message .= 'Content-Type: text/plain; charset=UTF-8' . "\r\n";
    $message .= 'Content-Disposition: inline' . "\r\n";
    $message .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n";
    $message .= "\r\n";
    $message .= quoted_printable_decode ( $body_text ) . "\r\n";
    $message .= "\r\n";
    $message .= '--' . $boundary . "\r\n";
    $message .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";
    $message .= 'Content-Disposition: inline' . "\r\n";
    $message .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n";
    $message .= "\r\n";
    $message .= quoted_printable_decode ( $body_html ) . "\r\n";
    $message .= '--' . $boundary . "\r\n";

    // 送信する
    if(!mail($mail_to,$subject, $message, $headers, $parameter)){
      echo "送信失敗";
    }else{
      echo "送信成功";
    }
  }

  if(!empty($_POST['sub4'])){
    $to = $_POST['mail'];
    $subject = "[TEST] HTML MAIL";
    $text=$_POST['text'];
    $message = "<html><body><h1>This is HTML MAIL</h1><p>{$text}</p></body></html>";
    // $headers = "From: from@example.com";
    // $headers .= "\r\n";
    // $headers .= "Content-type: text/html; charset=UTF-8";
    $headers = "Content-type: text/html; charset=UTF-8";
    mb_send_mail($to, $subject, $message, $headers); 
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="" method="post">
    <input type="email" name="mail" id="">
    <input type="submit" name="sub" value="sub">
  </form>
  <form action="" method="post">
    <input type="email" name="mail" id="">
    <input type="submit" name="sub2" value="sub2">
  </form>
  <form action="" method="post">
    <input type="email" name="mail" id="">
    <input type="submit" name="sub3" value="sub3">
  </form>
  <form action="" method="post">
    <input type="email" name="mail" id="">
    <textarea name="text" id="" cols="30" rows="10"></textarea>
    <input type="submit" name="sub4" value="sub4">
  </form>
</body>
</html>