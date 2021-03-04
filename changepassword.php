<?php
session_start();
if(!empty($_SESSION['login_flag'])){
  $fileopen=fopen("password.txt","r");
  $line=fgets($fileopen);
  echo $line;
}else{
  echo "<script>window.location.href = './write.php';</script>";
}

if(!empty($_POST['changesub'])){
  $new_password=$_POST['newpassword'];
  // echo $new_password;
  $tit=preg_replace( '/\\r\\n|\\n|\\r/', '', $new_password);
  $tit  = preg_replace("/( |　)/", "", $tit );
  
  if(!empty($tit)){
    $fp=fopen('password.txt','wb');
    fwrite($fp,$tit);
    echo "<script>window.location.href = './changepassword.php';</script>";    
  }

}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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