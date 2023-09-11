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

$name=$_POST['name'];

$sql_format = "select * from users.info where name = :name";
$sql=$connection -> prepare($sql_format);
$sql -> bindValue(':name',$name);
$sql -> execute();
$result = $sql -> fetchAll(PDO::FETCH_ASSOC);
if($result){
    echo true;
}else{
    echo false;
};
?>