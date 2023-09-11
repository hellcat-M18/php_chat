<?php
session_start();
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
$name = $_POST["name"];
$Upassword = $_POST["password"];
if(null!==$name&&$Upassword){
try{
    $sql_format = "select * from users.info where name=:name and password=:Upassword";
    $sql = $connection -> prepare($sql_format);
    $sql -> bindValue(':name',$name);
    $sql -> bindValue(':Upassword',$Upassword);
    $sql -> execute();
}catch(PDOException $e){
    print $e;
    $warn = "エラーが発生しました";
}
global $sql;
$result = $sql -> fetchAll(PDO::FETCH_ASSOC);
if($result){
    $_SESSION["result"] = $result;
    header("Location: ./main/mainPage.php");
}else{
    $warn = "ユーザーが見つかりませんでした";
}
}else{
    $warn = "必要事項を入力してください";
}
?>

<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset = "UFT-8">
<meta http-equiv="Cache-Control" content="no-cache">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>dashboard</title>
</head>
<body>
<link rel="stylesheet" href="style.css">
    <header>Dashboard</header>
        <h1 class="center_text">ログイン</h1>
        <?php
        global $warn;
        echo "<p class=warn>$warn</p>";
        ?>
        <form class="center_text" action="index.php" method="post">
        <table class="center_block" border ="1">
        <tr><td>ユーザー名</td><td><input type="text" name="name"></td></tr>
        <tr><td>パスワード</td><td><input type="text" name="password"></td></tr>
        </table>    
        <input class="button" type = "submit" value ="認証">
    </form>
    <div class="center_block">
    <a href="./account/C-account.php">アカウントの新規作成</a>
    </div>
</body>
</html>