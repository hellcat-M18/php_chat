<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache">
    <title>Document</title>
</head>
<link rel="stylesheet" href="style.css">
<body>
    <div class= "center_block">
        <header>Dashboard</header>
        <h1>ユーザー登録が完了しました</h1>
        <table border="2" class="center_block">
            <tr><td>名前</td><td><p id='name'></p></td></tr>
            <tr><td>パスワード</td><td><p id='password'></p></td></tr>
        </table>
        <div class="center_block">
        <a href="../../index.php">ログインページに戻る</a>
        </div>
        
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        let name = sessionStorage.getItem('name')
        let password = sessionStorage.getItem('password')
        console.log(name+":"+password)
        $('#name').text(name)
        $('#password').text(password)
    </script>
</body>
</html>