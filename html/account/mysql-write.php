<?php

$password=$_ENV['password'];

$dsn_format = "mysql:host=%s;dbname=%s;port=%s";
$dsn=sprintf($dsn_format,$_ENV["HOST"],$_ENV["DB"],$_ENV["PORT"]);
try{
    global $dsn;
    global $password;
    $connection = new PDO($dsn,$_ENV['USER'],$password);
} catch (PDOException $e) {
    print("エラー!: " . $e->getMessage() . "<br/gt;");
    die();
};

$name = $_POST["name"];
$Upassword = $_POST["Upassword"];

$sql_format = "insert into users.info (name,password) values (:name,:password)";
$sql = $connection -> prepare($sql_format);
$sql -> bindValue(':name',$name);
$sql -> bindValue(':password',$Upassword);
$sql -> execute();
?>