<?php
session_start();

$method='AES-128-CBC';
$hex_iv_string = bin2hex(openssl_random_pseudo_bytes(openssl_cipher_iv_length($method)));
$iv = hex2bin($hex_iv_string);

// 暗号化したい文字列
// $str = "保つのに時があり，捨てるのに時がある。";
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

// 暗号化
// $enc = convert($str, $pad);
// echo "暗号化した文字列:{$enc}\n";
// // 復号化 (P xor K) xor K = P
// $dec = convert($enc, $pad);
// echo "復号化した文字列:{$dec}\n";

if(!empty($_POST['changesub'])){
  $new_password=$_POST['newpassword'];
  // echo $new_password;
  $tit=preg_replace( '/\\r\\n|\\n|\\r/', '', $new_password);
  $tit  = preg_replace("/( |　)/", "", $tit );
  
  if(!empty($tit)){
    $fp=fopen('password.txt','wb');
    // $tit=json_encode($tit);

    // $tit=openssl_encrypt($tit,$method, 'password',0,$iv);
    $tit=convert($tit, $pad);
    fwrite($fp,$tit);
    echo "<script>window.location.href = './changepassword.php';</script>";    
  }

  }

if(!empty($_SESSION['login_flag'])){
  $fileopen=fopen("password.txt","r");
  $line=fgets($fileopen);
  // $line=json_decode($line,true);
  // $line=openssl_decrypt($line,$method,'password',0,$iv);
  $line=convert($line, $pad);;
  echo $line;
  // var_dump($line);
}else{
  echo "<script>window.location.href = './write.php';</script>";
}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="image/oka_icon.ico" type="image/x-icon">
  <link rel="icon" href="image/oka_icon.ico">
  <title>パスワード変更</title>
</head>
<body>
  <form action="" method="post">
    <input type="password" name="newpassword" id="newpassword" placeholder="新しいパスワード">
    <input type="submit" name="changesub" value="変更">
    <a href="write.php">戻る</a>
  </form>
</body>
</html>