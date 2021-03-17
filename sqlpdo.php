<?php
  function connectdatebase(){
    try {
      // $dbh = new PDO($dsn, $user, $password);
      // $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $pdo=new PDO("mysql:dbname=myblog;host=localhost;  charset=utf8;","root","password");
    } catch (PDOException $e) {
      $pdo=new PDO("mysql:dbname=or0e9abi5m_onlinemeeting;host=157.112.147.201; port=3306; charset=utf8;","or0e9abi5m_1","userlistid");
      // echo 'Connection failed: ' . $e->getMessage();
    }

    $sql="SET @i := 0; UPDATE contents SET id = (@i := @i +1);";
    $stmt2=$pdo->query($sql);

    return $pdo;
  }
  // echo "<script>window.location.href = './index.php';</script>";
?>