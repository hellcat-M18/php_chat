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
global $connection;
try{
    $sql_format = "select * from chat.log";
    $sql = $connection -> prepare($sql_format);
    $sql -> execute();
}catch(PDOException $e){
    print $e;
    $warn = "エラーが発生しました";
}
global $sql;
$result = $sql -> fetchAll(PDO::FETCH_ASSOC);
if(!isset($result)){
    $warn = "メッセージがありません";
}
global $result;
$array = [];
foreach ($result as $row) {
    array_push($array, array("time" => $row["time"], "content" => $row["author"].":".$row["content"]));
}
echo json_encode($array);
?>