<?php
$password=$_ENV["password"];
$dsn_format = "mysql:host=%s;dbname=%s;port=%s";


$dsn=sprintf($dsn_format,$_ENV["HOST"],$_ENV["DB"],$_ENV["PORT"]);
try{
    global $dsn;
    global $password;
    $connection = new PDO($dsn,$_ENV['USER'],$password);
} catch (PDOException $e) {
    print("エラー!: " . $e->getMessage() . "<br/gt;");
    die();
}
$message = $_POST["message"];
$name = $_POST["name"];
global $connection;
$sql_format = "insert into chat.log (author,content,time) values (:author,:content,:time)";
$sql = $connection -> prepare($sql_format);
$sql -> bindValue(':author',$name);
$sql -> bindValue(':content',$message);
$sql -> bindValue(':time',date("Y/m/d H:i:s"));
$sql -> execute();
?>